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
}