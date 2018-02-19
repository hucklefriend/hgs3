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
    public function import()
    {
        // 既存データのアップデート
        $this->update();

        $path = storage_path('master/soft');

        $files = File::files($path);

        $series = $this->getSeriesHash();

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

    private static function getSeriesId($name)
    {
        $sql = 'SELECT id FROM game_series WHERE `name` LIKE "%' . $name . '%"';

        $series = DB::select($sql);
        return $series[0]->id;
    }

    /**
     * データの更新
     */
    private function update()
    {
        $softs = include(storage_path('master/soft/update.php'));

        foreach ($softs as $s) {
            DB::table('game_softs')
                ->where('id', $s['id'])
                ->update($s);
        }

        unset($softs);
    }
}