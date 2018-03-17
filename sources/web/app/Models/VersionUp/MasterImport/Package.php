<?php
/**
 * パッケージインポート
 */


namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Constants\Game\Shop;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Package extends MasterImportAbstract
{
    /**
     * インポート
     *
     * @throws \Exception
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function import($date)
    {
        self::update($date);

        $path = storage_path('master/' . $date . '/package');
        if (!File::isDirectory($path)) {
            echo 'nothing package new data.' . PHP_EOL;
            return;
        } else {
            $files = File::files($path);

            $softs = self::getSoftHash();
            $companies = self::getCompanyHash();
            $platforms = self::getPlatformHash();

            foreach ($files as $filePath) {
                if (ends_with($filePath, 'update.php')) {
                    continue;
                }

                $data = json_decode(File::get($filePath), true);

                self::insert($data, $softs, $companies, $platforms);

                unset($data);
                unset($platform);
            }
        }

        $manualMethod = 'manual' . $date;
        if (method_exists(new self(), $manualMethod)) {
            self::$manualMethod();
        } else {
            echo 'nothing package manual update.' . PHP_EOL;
        }
    }

    /**
     * データ登録
     *
     * @param array $data
     * @param array $softs
     * @param array $companies
     * @param array $platforms
     * @throws \Exception
     */
    public static function insert(array $data, array $softs, array $companies, array $platforms)
    {
        if (isset($data['soft_id'])) {
            $softIds = $data['soft_id'];
        } else if (isset($data['soft_name'])) {
            $softIds = [];
            foreach($data['soft_name'] as $softName) {
                $softIds[] = $softs[$softName];
            }
        } else {
            echo 'ソフトが指定されてません。' . var_export($data, true);
            return;
        }

        foreach ($data['packages'] as $pkg) {
            echo $pkg['name'] . PHP_EOL;
            $package = new Orm\GamePackage;
            $package->name = $pkg['name'];
            $package->url = $pkg['url'];
            $package->release_int = $pkg['release_int'];
            $package->release_at = $pkg['release_at'];
            if (isset($pkg['company']) && isset($companies[$pkg['company']])) {
                $package->company_id = $companies[$pkg['company']] ?? null;
            }
            $package->platform_id = 0;
            if (isset($pkg['platform']) && isset($platforms[$pkg['platform']])) {
                $package->platform_id = $platforms[$pkg['platform']] ?? 0;
                if ($package->platform_id == 0) {
                    $plt = Orm\GamePlatform::where('acronym', $pkg['platform'])->get();
                    if ($plt) {
                        $package->platform_id = $plt->id;
                    }
                }
            }

            $package->save();

            foreach ($softIds as $softId) {
                DB::table('game_package_links')
                    ->insert([
                        'soft_id' => $softId,
                        'package_id' => $package->id,
                        'sort_order' => $pkg['release_int']
                    ]);
            }

            if (isset($pkg['shop'])) {
                if (is_array($pkg['shop'])) {
                    foreach ($pkg['shop'] as $shop => $shopUrl) {
                        $shopId = Shop::getIdByName($shop);
                        if ($shopId) {
                            if ($shopId == Shop::AMAZON) {
                                if (env('APP_ENV') == 'production' || env('APP_ENV') == 'staging') {
                                    \Hgs3\Models\Game\Package::saveImageByAsin($package->id, $shopUrl);
                                }
                            } else if ($shopUrl) {
                                DB::table('game_package_shops')
                                    ->insert([
                                        'package_id' => $package->id,
                                        'shop_id'    => $shopId,
                                        'shop_url'   => $shopUrl
                                    ]);
                            }
                        }
                    }
                } else {
                    $shopId = Shop::getIdByName($pkg['shop']);
                    if ($shopId) {
                        if ($shopId == Shop::AMAZON) {
                            if (env('APP_ENV') == 'production' || env('APP_ENV') == 'staging') {
                                \Hgs3\Models\Game\Package::saveImageByAsin($package->id, $pkg['asin']);
                            }
                        } else if (!empty($pkg['shop_url'])) {
                            DB::table('game_package_shops')
                                ->insert([
                                    'package_id' => $package->id,
                                    'shop_id'    => $shopId,
                                    'shop_url'   => $pkg['shop_url']
                                ]);
                        }
                    }
                }
            }

            unset($package);
        }
    }

    /**
     * データの更新
     *
     * @param $date
     */
    private static function update($date)
    {
        $path = storage_path('master/' . $date . '/package/update.php');
        if (!File::isFile($path)) {
            echo 'nothing package update data.' . PHP_EOL;
            return;
        }

        $packages = include($path);
        foreach ($packages as $p) {
            $pkg = Orm\GamePackage::find($p['id']);

            $data = $p;
            unset($data['id']);
            $pkg->update($data);

            unset($data);
            unset($pkg);
        }

        unset($packages);
    }

    /**
     * 手動設定
     */
    private static function manual20180225()
    {
        // 既存データの更新

        // 男子校であった怖い話に不要なパッケージ
        DB::table('game_package_links')
            ->where('soft_id', 243)
            ->delete();

        DB::table('game_package_links')
            ->whereIn('soft_id', [242, 239, 241, 240])
            ->where('package_id', 410)
            ->delete();

        // かまいたちの夜2のメーカーIDがNULL
        DB::table('game_packages')
            ->whereIn('id', [101, 102, 103, 104, 105, 90, 97, 98, 99, 100])
            ->update(['company_id' => 103]);

        // Dの食卓
        DB::table('game_packages')
            ->whereIn('id', [461, 462, 463, 464, 465, 466])
            ->update(['company_id' => 45]);

        // 月陽炎
        DB::table('game_packages')
            ->whereIn('id', [385, 386])
            ->update(['company_id' => self::getCompanyId('すたじおみりす')]);

        // 魔女たちの眠り
        DB::table('game_packages')
            ->whereIn('id', [147])
            ->update(['company_id' => self::getCompanyId('パック')]);

        // 魔女たちの眠り完全版
        DB::table('game_packages')
            ->whereIn('id', [148])
            ->update(['company_id' => 9]);

        // 歪みの国のアリス
        DB::table('game_packages')
            ->whereIn('id', [127])
            ->update(['company_id' => self::getCompanyId('SUNSOFT')]);

        // お馬が穐
        DB::table('game_packages')
            ->whereIn('id', [86,87,88,89])
            ->update(['company_id' => 54]);


        // 超怖い話
        DB::table('game_packages')
            ->where('id', 400)
            ->update(['company_id' => 96, 'url' => 'https://www.nintendo.co.jp/ds/software/bkaj/index.html']);
    }
}