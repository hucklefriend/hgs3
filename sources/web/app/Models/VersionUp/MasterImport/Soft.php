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

                $soft = new Orm\GameSoft;
                $soft->name = $data['name'];
                $soft->phonetic = $data['phonetic'];
                $soft->phonetic2 = $data['phonetic2'] ?? $data['phonetic'];
                $soft->genre = '';//$data['genre'];

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
    private static function manual20180519()
    {
        // うみねこを同人と、CSで分ける
        // CSはさらにEP1～4と、EP5～8で分ける(PS3版に合わせる)
        DB::table('game_softs')
            ->where('id', 239)
            ->update(['original_package_id' => null]);

        // 鬼太郎が2つある、マーセ3Dは削除、物体Xも1つに統合
        DB::table('game_softs')
            ->whereIn('id', [307, 244, 122, 150, 217, 229, 220])
            ->delete();
    }
}