<?php
/**
 * ゲームソフトインポート
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;
use Hgs3\Models\Timeline\NewInformation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Soft extends MasterImportAbstract
{
    /**
     * インポート
     */
    public static function import($date)
    {
        $manualMethod = 'manual' . $date;
        if (method_exists(new self(), $manualMethod)) {
            self::$manualMethod();
        } else {
            echo 'nothing soft manual update.' . PHP_EOL;
        }

        $path = storage_path('master/' . $date . '/soft');
        if (!File::isDirectory($path)) {
            echo 'nothing soft new data.' . PHP_EOL;
        } else {
            $files = File::files($path);
            $series = self::getSeriesHash();

            foreach ($files as $filePath) {
                if (ends_with($filePath, 'update.php')) {
                    continue;
                }

                $data = json_decode(File::get($filePath), true);
                $data['genre'] = '';

                $isNew = Orm\GameSoft::find($data['id']) == null;

                $orm = Orm\GameSoft::updateOrCreate(
                    ['id' => $data['id']],
                    $data
                );

                if ($isNew) {
                    NewInformation::addNewGameText($orm);
                } else {
                    NewInformation::addUpdateGameText($orm);
                }

                unset($data);
                unset($orm);
            }
        }

        // 既存データのアップデート
        self::update($date);
    }

    /**
     * データの更新
     *
     * @param $date
     */
    private static function update($date)
    {
        $path = storage_path('master/' . $date . '/soft/update.php');
        if (!File::isFile($path)) {
            echo 'nothing soft update data.' . PHP_EOL;
            return;
        }

        $softs = include($path);

        foreach ($softs as $s) {
            unset($s['created_at']);
            $s['updated_at'] = DB::raw('NOW()');

            DB::table('game_softs')
                ->where('id', $s['id'])
                ->update($s);
        }

        unset($softs);
    }

    /**
     * 手動設定
     */
    private static function manual20180611()
    {
        // アパシーを一回削除
        DB::table('game_softs')
            ->whereIn('id', [242])
            ->delete();
    }
}