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

                $orm->id = $data['id'];

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
    private static function manual20180604()
    {
        DB::table('game_softs')
            ->whereIn('id', [343, 199, 210, 340, 318, 341, 206, 201, 347, 211,198, 338, 51, 212, 218, 216, 219,
                339, 324, 227, 215, 228, 208, 204, 325, 205, 326, 298, 297, 358, 203, 330, 329, 209, 200, 223, 321, 222,
                224, 213, 225, 226, 207])
            ->update(['introduction_from_adult' => 1]);
    }

    public static function manual20180701()
    {
        DB::table('game_softs')
            ->whereIn('id', [343, 199, 210, 340, 318, 341, 206, 201, 347, 198, 338, 51, 212, 218, 216, 219,
                339, 324, 227, 215, 228, 208, 204, 325, 205, 326, 298, 297, 358, 203, 330, 329, 209, 200, 223, 321, 222,
                224, 213, 225, 226, 207, 358])
            ->update(['adult_only_flag' => 1]);
    }
}