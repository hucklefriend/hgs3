<?php
/**
 * ゲームソフトインポート
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Soft extends MasterImportAbstract
{
    /**
     * インポート
     */
    public static function import($date)
    {
        // 既存データのアップデート
        self::update($date);

        $path = storage_path('master/soft/' . $date);
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

                $soft = new Orm\GameSoft;
                $soft->name = $data['name'];
                $soft->phonetic = $data['phonetic'];
                $soft->phonetic2 = $data['phonetic2'] ?? $data['phonetic'];
                $soft->genre = $data['genre'];

                if (isset($data['series'])) {
                    if (isset($series[$data['series']])) {
                        $soft->series_id = $series[$data['series']];
                    } else {
                        $s = new Orm\GameSeries;
                        $s->name = $data['series'];
                        $s->phonetic = $data['series'];
                        $s->save();

                        $soft->series_id = $s->id;
                        unset($s);
                    }
                }

                $soft->save();
                unset($data);
            }
        }

        $manualMethod = 'manual' . $date;
        if (method_exists(new self(), $manualMethod)) {
            self::$manualMethod();
        } else {
            echo 'nothing soft manual update.' . PHP_EOL;
        }
    }

    /**
     * データの更新
     *
     * @param $date
     */
    private static function update($date)
    {
        $path = storage_path('master/soft/' . $date . '/update.php');
        if (!File::isFile($path)) {
            echo 'nothing soft update data.' . PHP_EOL;
            return;
        }

        $softs = include($path);

        foreach ($softs as $s) {
            DB::table('game_softs')
                ->where('id', $s['id'])
                ->update($s);
        }

        unset($softs);
    }

    /**
     * 手動設定2017.2.25
     *
     * @throws \Exception
     */
    private static function manual20180225()
    {
        // 消す。うみねこの一部とデッドラ
        Orm\GameSoft::whereIn('id', [24, 147, 240, 241, 139, 140, 250])
            ->delete();

        // デッドアイランドをシリーズ化
        DB::table('game_softs')
            ->where('id', 256)
            ->update([
                'phonetic2' => 'でっどあいらんど10',
                'series_id' => self::getSeriesId('DEAD ISLAND'),
                'order_in_series' => 1
            ]);

        // キャサリンをシリーズ化
        DB::table('game_softs')
            ->where('id', 233)
            ->update([
                'phonetic2' => 'きゃさりん10',
                'series_id' => self::getSeriesId('キャサリン'),
                'order_in_series' => 1
            ]);
    }

    /**
     * 手動設定2017.3.4
     */
    private static function manual20180304()
    {
        // デッドアイランドのシリーズがおかしい
        DB::table('game_softs')
            ->where('id', 277)
            ->update(['series_id' => 52]);
    }
}