<?php
/**
 * ゲームショップインポート
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Shop extends MasterImportAbstract
{
    /**
     * インポート
     *
     * @throws \Exception
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function import($date)
    {
        // 新規データの追加
        $path = storage_path('master/' . $date . '/shop');
        if (!File::isDirectory($path)) {
            echo 'nothing shop new data.' . PHP_EOL;
        } else {
            $files = File::files($path);
            foreach ($files as $filePath) {
                $data = \GuzzleHttp\json_decode(File::get($filePath), true);

                $shopId = \Hgs3\Constants\Game\Shop::getIdByName($data['shop']);
                $data['shop_id'] = $shopId;
                unset($data['shop']);

                $orm = new Orm\GamePackageShop($data);
                $orm->insertOrUpdate();

                unset($orm);
                unset($data);
            }
        }

        $manualMethod = 'manual' . $date;
        if (method_exists(new self(), $manualMethod)) {
            self::$manualMethod();
        } else {
            echo 'nothing shop manual update.' . PHP_EOL;
        }
    }

    /**
     * 20180606アップデートの手動分
     *
     * @throws \Exception
     */
    private static function manual20180606()
    {
        // OutlastのPS版は削除
        DB::table('game_package_shops')
            ->whereIn('package_id', [574, 577])
            ->where('shop_id', \Hgs3\Constants\Game\Shop::PLAY_STATION_STORE)
            ->delete();
        // Outlast2のXB版は削除
        DB::table('game_package_shops')
            ->whereIn('package_id', [578])
            ->where('shop_id', \Hgs3\Constants\Game\Shop::MICROSOFT_STORE)
            ->delete();

        DB::table('game_package_shops')
            ->where('package_id', 575)
            ->where('shop_id', \Hgs3\Constants\Game\Shop::MICROSOFT_STORE)
            ->update(['shop_url' => 'https://www.microsoft.com/ja-jp/p/outlast/bp3gh4d3hp2h']);

        self::packageShopCombine(498, 497, \Hgs3\Constants\Game\Shop::PLAY_STATION_STORE);
    }

    private static function packageShopCombine($fromPkgId, $toPackageId, $shopId)
    {
        DB::table('game_package_shops')
            ->where('package_id', $fromPkgId)
            ->where('shop_id', $shopId)
            ->update(['package_id' => $toPackageId]);

        DB::table('game_packages')
            ->where('id', $fromPkgId)
            ->delete();
        DB::table('game_package_links')
            ->where('package_id', $fromPkgId)
            ->delete();
    }
}