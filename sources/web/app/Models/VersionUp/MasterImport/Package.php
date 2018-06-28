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
                //NewInformation::addUpdateGameText($soft);
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

        if (isset($data->acronym)) {
            $package->acronym = $data->acronym;
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

                    if ($shopUrl == 'delete') {
                        Orm\GamePackageShop::where('package_id', $package->id)
                            ->where('shop_id', $shopId)
                            ->delete();
                    } else {

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
            if ($pkg == null) {
                continue;
            }


            $data = $p;
            unset($data['id']);
            $pkg->update($data);
/*
            $links = Orm\GamePackageLink::where('package_id', $pkg->id)
                ->get();
            foreach ($links as $link) {
                $updated[$link->soft_id] = $link->soft_id;
            }
*/
            unset($data);
            unset($pkg);
        }

        unset($packages);

        return $updated;
    }

    /**
     * 手動設定
     */
    private static function manual20180603()
    {
        DB::table('game_softs')
            ->whereIn('id', [242, 243])
            ->delete();
        DB::table('game_package_links')
            ->whereIn('soft_id', [242, 243])
            ->delete();
        DB::table('game_package_links')
            ->where('soft_id', 207)
            ->whereIn('package_id', [816, 819])
            ->delete();

        DB::table('game_packages')
            ->whereIn('id', [725, 665, 723, 722, 724, 572])
            ->update(['is_adult' => 1]);

        DB::table('game_packages')
            ->whereIn('id', [238, 587, 575, 574, 573, 576, 577, 578, 834, 833])
            ->update(['is_adult' => 2]);

        DB::table('game_packages')
            ->whereIn('id', [517, 500])
            ->delete();
        DB::table('game_package_shops')
            ->whereIn('package_id', [517, 500])
            ->delete();
        DB::table('game_package_links')
            ->whereIn('package_id', [517, 500])
            ->delete();

        DB::table('game_series')
            ->whereIn('id', [18])
            ->delete();

        $deleteShops = [
            [620, Shop::DMM],
            [648, Shop::DMM],
            [647, Shop::DMM],
            [688, Shop::DMM],
        ];
        foreach ($deleteShops as $deleteShop) {
            self::deleteShop($deleteShop[0], $deleteShop[1]);
        }
    }

    private static function manual20180604()
    {
        DB::table('game_packages')
            ->whereIn('id', [721, 726, 727, 729, 747, 743, 744, 745, 746, 823, 748, 749, 750, 751, 158,
                757, 756, 755, 752, 753, 754, 758, 759, 760, 761, 762, 763, 765, 764, 766, 767, 768, 769, 770,
                771, 640, 639, 772, 773, 803, 802, 829, 809, 811, 812, 816, 815, 814, 819, 818, 817])
            ->update(['is_adult' => 1]);

        DB::table('game_packages')
            ->whereIn('id', [719, 720, 564, 565, 740, 853, 582, 583])
            ->update(['is_adult' => 2]);

        DB::table('game_packages')
            ->whereIn('id', [841])
            ->update(['company_id' => 140]);

        DB::table('game_packages')
            ->where('company_id', 122)
            ->update(['company_id' => 151]);

    }

    private static function manual20180605()
    {
        DB::table('game_package_links')
            ->where('package_id', 547)
            ->update(['package_id' => 540]);

        DB::table('game_packages')
            ->whereIn('id', [547])
            ->delete();
        DB::table('game_package_shops')
            ->whereIn('package_id', [547])
            ->delete();
        DB::table('game_package_links')
            ->whereIn('package_id', [547])
            ->delete();

        DB::table('game_package_links')
            ->where('package_id', 852)
            ->update(['soft_id' => 235]);

        DB::table('game_packages')
            ->where('id', 137)
            ->update(['name' => '夜想曲2 PS one Books']);

        $intro =<<< INTRO
コノ女、嘘ニ憑カレ、真ヲ突ク。

都市伝説――
それは、口承される噂話のうち、現代発祥のもので、根拠が曖昧・不明であるもの。
ここに、またひとつ。
恐怖に彩られた蟲惑敵な都市伝説が生まれようとしていた。
INTRO;
        DB::table('game_softs')
            ->where('id', 313)
            ->update(['introduction' => $intro]);

        DB::table('game_official_sites')
            ->whereIn('url', [
                'http://game.intergrow.jp/layersoffear/',
                'http://www.gae.co.jp/arc/1493',
            ])->delete();

        DB::table('game_packages')
            ->whereIn('id', [579])
            ->update(['is_adult' => 0]);
    }

    private static function manual20180606()
    {
        DB::table('game_packages')
            ->whereIn('id', [635])
            ->update(['is_adult' => 0]);
        DB::table('game_packages')
            ->whereIn('id', [852])
            ->update(['is_adult' => 2]);

        DB::table('game_packages')
            ->whereIn('id', [12, 13, 276, 278, 277, 436, 435])
            ->delete();
    }

    private static function manual20180607()
    {
        DB::table('game_packages')
            ->whereIn('id', [509, 501])
            ->delete();

        DB::table('game_package_links')
            ->where('soft_id', 161)
            ->where('package_id', 872)
            ->delete();
        DB::table('game_package_links')
            ->where('package_id', 885)
            ->where('soft_id', 356)
            ->delete();
    }

    private static function manual20180701()
    {
    }

    private static function deleteShop($pkgId, $shopId)
    {
        DB::table('game_package_shops')
            ->where('package_id', $pkgId)
            ->where('shop_id', $shopId)
            ->delete();
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

    public static function updateShopImage()
    {
        // なるべくAmazonの画像を使うが、指定したIDのものはDMMの画像を使う
        $dmmId = [];
        $dmms = [Shop::DMM, Shop::DMM_R18];

        $packages = Orm\GamePackage::all();

        foreach ($packages as $pkg) {
            $shopImages = Orm\GamePackageShop::where('package_id', $pkg->id)
                ->whereIn('shop_id', [Shop::AMAZON, Shop::DMM, Shop::DMM_R18])
                ->get();

            if ($shopImages->isNotEmpty()) {
                $pkg->shop_id = $shopImages[0]->shop_id;
                $pkg->small_image_url = $shopImages[0]->small_image_url;
                $pkg->medium_image_url = $shopImages[0]->medium_image_url;
                $pkg->large_image_url = $shopImages[0]->large_image_url;

                $useDmm = in_array($pkg->id, $dmmId);

                for ($i = 1; $i < $shopImages->count(); $i++) {
                    if ($useDmm && in_array($shopImages[$i]->shop_id, $dmms)) {
                        $pkg->shop_id = $shopImages[$i]->shop_id;
                        $pkg->small_image_url = $shopImages[$i]->small_image_url;
                        $pkg->medium_image_url = $shopImages[$i]->medium_image_url;
                        $pkg->large_image_url = $shopImages[$i]->large_image_url;
                    } else if ($shopImages[$i]->shop_id == Shop::AMAZON) {
                        $pkg->shop_id = $shopImages[$i]->shop_id;
                        $pkg->small_image_url = $shopImages[$i]->small_image_url;
                        $pkg->medium_image_url = $shopImages[$i]->medium_image_url;
                        $pkg->large_image_url = $shopImages[$i]->large_image_url;
                    }
                }
            } else {
                $pkg->shop_id = null;
                $pkg->small_image_url = null;
                $pkg->medium_image_url = null;
                $pkg->large_image_url = null;
            }

            $pkg->save();

            unset($shopImages);
        }
    }

    public static function updateFirstReleaseInt()
    {
        $sql =<<< SQL
UPDATE game_softs, 
(
	SELECT lnk.soft_id, MIN(pkg.release_int) AS first_release_int
	FROM (SELECT id, release_int FROM game_packages) pkg
		INNER JOIN game_package_links lnk ON pkg.id = lnk.package_id
	GROUP BY lnk.soft_id
) data
SET game_softs.first_release_int = data.first_release_int
WHERE game_softs.id = data.soft_id
SQL;

        DB::update($sql);
    }
}