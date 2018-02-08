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
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function import()
    {
        // 新規データの追加
        $path = storage_path('master/series');

        $files = File::files($path);
        foreach ($files as $filePath) {
            $data = \GuzzleHttp\json_decode(File::get($filePath), true);

            DB::table('game_series')
                ->insert($data);

            unset($data);
        }
    }
}