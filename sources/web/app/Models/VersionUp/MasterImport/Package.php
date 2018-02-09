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
     */
    public function import()
    {
        $this->update();

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

                if (is_array($pkg['shop'])) {
                    foreach ($pkg['shop'] as $shop => $shopUrl) {
                        $shopId = Shop::getIdByName($shop);
                        if ($shopId) {
                            if ($shopId == Shop::AMAZON) {
                                \Hgs3\Models\Game\Package::saveImageByAsin($package->id, $shopUrl);
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
                            \Hgs3\Models\Game\Package::saveImageByAsin($package->id, $pkg['asin']);
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