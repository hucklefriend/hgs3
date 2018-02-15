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
    public function import()
    {
        $this->update();

        // 男子校であった怖い話に不要なパッケージ
        DB::table('game_package_links')
            ->where('soft_id', 243)
            ->delete();

        DB::table('game_package_links')
            ->whereIn('soft_id', [242, 239, 241, 240])
            ->where('package_id', 410)
            ->delete();

        $path = storage_path('master/package');

        $files = File::files($path);

        $softs = $this->getSoftHash();
        $companies = $this->getCompanyHash();
        $platforms = $this->getPlatformHash();

        foreach ($files as $filePath) {
            if (ends_with($filePath, 'update.php')) {
                continue;
            }

            $data = json_decode(File::get($filePath), true);

            self::insert($data, $softs, $companies, $platforms);

            unset($data);
            unset($platform);
        }

        // 既存データの更新

        // かまいたちの夜2のメーカーIDがNULL
        DB::table('game_packages')
            ->whereIn('id', [101, 102, 103, 104, 105])
            ->update(['company_id' => 103]);

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
    }

    /**
     * 会社IDを取得
     *
     * @param string $name
     * @return mixed
     */
    private static function getCompanyId($name)
    {
        $sql = 'SELECT id FROM game_companies WHERE name LIKE "%' . $name . '%"';

        $company = DB::select($sql);
        return $company[0]->id;
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

        foreach ($softIds as $softId) {
            foreach ($data['packages'] as $pkg) {
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

                DB::table('game_package_links')
                    ->insert([
                        'soft_id'    => $softId,
                        'package_id' => $package->id,
                        'sort_order' => $pkg['release_int']
                    ]);

                if (isset($pkg['shop'])) {
                    if (is_array($pkg['shop'])) {
                        foreach ($pkg['shop'] as $shop => $shopUrl) {
                            $shopId = Shop::getIdByName($shop);
                            if ($shopId) {
                                if ($shopId == Shop::AMAZON) {
                                    // TODO 戻す
                                    //\Hgs3\Models\Game\Package::saveImageByAsin($package->id, $shopUrl);
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
                                // TODO 戻す
                                //\Hgs3\Models\Game\Package::saveImageByAsin($package->id, $pkg['asin']);
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
    }

    /**
     * データの更新
     */
    private function update()
    {
        if (!File::exists(storage_path('master/package/update.php'))) {
            return;
        }

        $packages = include(storage_path('master/package/update.php'));

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
}