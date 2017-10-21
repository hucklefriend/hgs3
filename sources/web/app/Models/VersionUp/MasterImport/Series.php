<?php
/**
 * ゲームシリーズインポート
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\File;

class Series extends MasterImportAbstract
{
    /**
     * インポート
     */
    public function import()
    {
        // 新規データの追加
        $path = resource_path('master/series');

        $files = File::files($path);
        foreach ($files as $filePath) {
            $data = \GuzzleHttp\json_decode(File::get($filePath), true);

            $series = new Orm\GameSeries($data);
            $series->save();

            unset($data);
            unset($series);
        }
    }
}