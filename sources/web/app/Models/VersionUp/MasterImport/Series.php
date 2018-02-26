<?php
/**
 * ゲームシリーズインポート
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Series extends MasterImportAbstract
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
        $path = storage_path('master/' . $date . '/series');
        if (!File::isDirectory($path)) {
            echo 'nothing series new data.' . PHP_EOL;
        } else {
            $files = File::files($path);
            foreach ($files as $filePath) {
                $data = \GuzzleHttp\json_decode(File::get($filePath), true);

                DB::table('game_series')
                    ->insert($data);

                unset($data);
            }
        }

        $manualMethod = 'manual' . $date;
        if (method_exists(new self(), $manualMethod)) {
            self::$manualMethod();
        } else {
            echo 'nothing series manual update.' . PHP_EOL;
        }
    }

    /**
     * 20180225アップデートの手動分
     *
     * @throws \Exception
     */
    private static function manual20180225()
    {
        // 削除：デッドラ
        Orm\GameSeries::whereIn('id', [49, 22])
            ->delete();
    }

    /**
     * 手動設定2017.3.4
     *
     * @throws \Exception
     */
    private static function manual20180304()
    {
        // デッドアイランドが2つあるので片方を削除
        DB::table('game_series')
            ->where('id', 55)
            ->delete();
    }
}