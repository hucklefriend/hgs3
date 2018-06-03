<?php
/**
 * パッケージインポート
 */


namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Constants\Game\Shop;
use Hgs3\Log;
use Hgs3\Models\Orm;
use Hgs3\Models\Timeline\NewInformation;
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
        if ($date == 20180401) return;

        $manualMethod = 'manual' . $date;
        if (method_exists(new self(), $manualMethod)) {
            self::$manualMethod();
        } else {
            echo 'nothing package manual update.' . PHP_EOL;
        }

        $path = storage_path('master/' . $date . '/package');
        if (!File::isDirectory($path)) {
            echo 'nothing package new data.' . PHP_EOL;
            return;
        } else {
            $files = File::files($path);

            $softs = self::getSoftHash();
            $companies = self::getCompanyHash();
            $platforms = self::getPlatformHash();

            $updateSofts = [];

            foreach ($files as $filePath) {
                if (ends_with($filePath, 'update.php')) {
                    continue;
                }

                $data = json_decode(File::get($filePath));

                self::insert($data, $softs, $companies, $platforms);

                $links = Orm\GamePackageLink::where('package_id', $data->id)
                    ->get();
                foreach ($links as $link) {
                    $updateSofts[$link->soft_id] = $link->soft_id;
                }

                unset($data);
                unset($platform);
            }
        }

        $updateSofts = array_merge(self::update($date), $updateSofts);
        foreach ($updateSofts as $softId) {
            $soft = Orm\GameSoft::find($softId);
            if ($soft !== null) {
                NewInformation::addUpdateGameText($soft);
            } else {
                echo 'nothing soft id: ' . $softId . PHP_EOL;
            }
        }
    }

    /**
     * データ登録
     *
     * @param $data
     * @param array $softs
     * @param array $companies
     * @param array $platforms
     * @throws \Exception
     */
    public static function insert($data, array $softs, array $companies, array $platforms)
    {
        echo sprintf('package: %s (%d)', $data->name ?? 'no name', $data->id). PHP_EOL;

        // 登録済みか
        $package = Orm\GamePackage::find($data->id);
        if ($package == null) {
            $package = new Orm\GamePackage(['id' => $data->id]);
        }

        $softIds = [];
        if (isset($data->soft_id)) {
            $softIds = $data->soft_id;
        } else if (isset($data->soft_name)) {
            $softIds = [];
            foreach($data->soft_name as $softName) {
                $softIds[] = $softs[$softName];
            }
        }

        if (isset($data->name)) {
            $package->name = $data->name;
        }

        if (isset($data->release_int)) {
            $package->release_int = $data->release_int;
        }

        if (isset($data->release_at)) {
            $package->release_at = $data->release_at;
        }

        if (isset($data->company) && isset($companies[$data->company])) {
            $package->company_id = $companies[$data->company] ?? null;
        }

        if (isset($data->platform) && isset($platforms[$data->platform])) {
            $package->platform_id = $platforms[$data->platform] ?? 0;
            if ($package->platform_id == 0) {
                $plt = Orm\GamePlatform::where('acronym', $data->platform)->get();
                if ($plt) {
                    $package->platform_id = $plt->id;
                }
            }
        }

        $package->save();

        foreach ($softIds as $softId) {
            Orm\GamePackageLink::ignoreInsert($softId, $package->id, $package->release_int);
        }

        if (isset($data->shop)) {
            if (!is_string($data->shop)) {
                foreach ($data->shop as $shop => $shopUrl) {
                    $shopId = Shop::getIdByName($shop);

                    if ($shopId) {
                        if ($shopId == Shop::AMAZON) {
                            //if (env('APP_ENV') == 'production' || env('APP_ENV') == 'staging') {
                                \Hgs3\Models\Game\Package::saveImageByAsin($package->id, $shopUrl);
                            //}
                        } else if ($shopId == Shop::DMM || $shopId == Shop::DMM_R18) {
                            //if (env('APP_ENV') == 'production' || env('APP_ENV') == 'staging') {
                                \Hgs3\Models\Game\Package::saveImageByDmm($package->id, $shopUrl, $shopId);
                            //}
                        } else if ($shopUrl) {
                            $pkgShop = new Orm\GamePackageShop([
                                'package_id' => $package->id,
                                'shop_id'    => $shopId,
                                'shop_url'   => $shopUrl
                            ]);

                            $pkgShop->insertOrUpdate();
                        }
                    }
                }
            } else {
                $shopId = Shop::getIdByName($data->shop);
                if ($shopId) {
                    if ($shopId == Shop::AMAZON) {
                        if (env('APP_ENV') == 'production' || env('APP_ENV') == 'staging') {
                            \Hgs3\Models\Game\Package::saveImageByAsin($package->id, $data->asin);
                        }
                    } else if (!empty($data->shop_url)) {
                        $pkgShop = new Orm\GamePackageShop([
                            'package_id' => $package->id,
                            'shop_id'    => $shopId,
                            'shop_url'   => $data->shop_url
                        ]);

                        $pkgShop->insertOrUpdate();
                    }
                }
            }
        }
    }

    /**
     * データの更新
     *
     * @param $date
     * @return array
     */
    private static function update($date)
    {
        $path = storage_path('master/' . $date . '/package/update.php');
        if (!File::isFile($path)) {
            echo 'nothing package update data.' . PHP_EOL;
            return [];
        }

        $updated = [];

        $packages = include($path);
        foreach ($packages as $p) {
            $pkg = Orm\GamePackage::find($p['id']);

            $data = $p;
            unset($data['id']);
            $pkg->update($data);

            $links = Orm\GamePackageLink::where('package_id', $data['id'])
                ->get();
            foreach ($links as $link) {
                $updated[$link->soft_id] = $link->soft_id;
            }

            unset($data);
            unset($pkg);
        }

        unset($packages);

        return $updated;
    }

    /**
     * 手動設定
     */
    private static function manual20180519()
    {
        // うみねこを同人と、CSで分ける
        // CSはさらにEP1～4と、EP5～8で分ける(PS3版に合わせる)

        DB::table('game_package_links')
            ->where('soft_id', 239)
            ->update(['soft_id' => 247]);

        DB::table('game_package_links')
            ->where('soft_id', 122)
            ->update(['soft_id' => 123]);


        DB::table('game_package_links')
            ->where('soft_id', 89)
            ->where('package_id', '>=', 685)
            ->delete();

        DB::table('game_package_links')
            ->whereIn('package_id', [421, 210,364,369,370,371,387,388,389,390,391,392])
            ->delete();
        DB::table('game_package_shops')
            ->whereBetween('package_id', [685, 763, 421,364,369,370,371,387,388,389,390,391,392])
            ->delete();
        DB::table('game_packages')
            ->whereBetween('id', [685, 763, 421, 210,364,369,370,371,387,388,389,390,391,392])
            ->delete();


        DB::table('game_packages')
            ->whereIn('id', [669,625,665,666,679,660,661,633,634,635,662,663,664,638,653,641,642,571,579,646,647,648,631,632])
            ->update(['is_adult' => 1]);
    }

    public static function updateShopReleaseInt()
    {
        $sql =<<< SQL
UPDATE
	game_package_shops, game_packages
SET
	game_package_shops.release_int = game_packages.release_int
	, game_package_shops.is_adult = game_packages.is_adult
WHERE
	game_package_shops.package_id = game_packages.id
SQL;

        DB::update($sql);

    }
}