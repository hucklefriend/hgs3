<?php
/**
 * ゲームソフトインポート
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\File;

class Soft extends MasterImportAbstract
{
    /**
     * インポート
     */
    public function import()
    {
        // 既存データのアップデート
        //$this->update();

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

        Orm\GameSoft::whereIn('id', [24, 147])
            ->delete();
    }
}