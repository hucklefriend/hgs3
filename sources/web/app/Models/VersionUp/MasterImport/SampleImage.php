<?php
/**
 * サンプルイメージインポート
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SampleImage extends MasterImportAbstract
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
            echo 'nothing sample image manual update.' . PHP_EOL;
        }

        $path = storage_path('master/' . $date . '/sample_image');
        if (!File::isDirectory($path)) {
            echo 'nothing sample image new data.' . PHP_EOL;
        } else {
            $files = File::files($path);

            foreach ($files as $filePath) {
                if (ends_with($filePath, 'update.php')) {
                    continue;
                }

                if (ends_with($filePath, 'insert.php')) {
                    $data = require $filePath;
                } else {
                    $data = json_decode(File::get($filePath), true);
                }

                foreach ($data as $row) {
                    $img = new Orm\GameSampleImage($row);
                    $img->soft_id = $row['soft_id'];
                    $img->no = $row['no'];
                    $img->package_id = $row['package_id'];
                    $img->shop_id = $row['shop_id'];
                    $img->small_image_url = $row['small_image_url'];
                    $img->large_image_url = $row['large_image_url'];
                    $img->save2();
                }
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
        $path = storage_path('master/' . $date . '/sample_image/update.php');
        if (!File::isFile($path)) {
            echo 'nothing sample image update data.' . PHP_EOL;
            return;
        }

        $officialSites = include($path);

        foreach ($officialSites as $s) {
            DB::table('game_sample_images')
                ->where('soft_id', $s['soft_id'])
                ->where('no', $s['no'])
                ->update($s);
        }

        unset($softs);
    }
}