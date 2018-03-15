<?php
/**
 * プラットフォームインポート
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Platform extends MasterImportAbstract
{
    /**
     * インポート
     *
     * @param $date
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function import($date)
    {
        self::update($date);

        $path = storage_path('master/' . $date . '/platform');
        if (!File::isDirectory($path)) {
            echo 'nothing platform new data.' . PHP_EOL;
        } else {
            $files = File::files($path);

            $companies = self::getCompanyHash();

            foreach ($files as $filePath) {
                if (ends_with($filePath, 'update.php')) {
                    continue;
                }

                $data = \GuzzleHttp\json_decode(File::get($filePath), true);

                $data['company_id'] = $companies[$data['company']] ?? null;
                unset($data['company']);


                $platform = new Orm\GamePlatform($data);
                $platform->save();

                unset($data);
                unset($platform);
            }
        }

        $manualMethod = 'manual' . $date;
        if (method_exists(new self(), $manualMethod)) {
            self::$manualMethod();
        } else {
            echo 'nothing platform manual update.' . PHP_EOL;
        }
    }

    /**
     * データの更新
     */
    private static function update($date)
    {
        $path = storage_path('master/' . $date . '/platform/update.php');
        if (!File::isFile($path)) {
            echo 'nothing platform update data.' . PHP_EOL;
            return;
        }

        $platforms = include($path);

        foreach ($platforms as $p) {
            $platform = Orm\GamePlatform::find($p['id']);

            $data = $p;
            unset($data['id']);
            $platform->update($data);

            unset($data);
            unset($company);
        }

        unset($platforms);
    }

    /**
     * 手動設定
     */
    private static function manual20180317()
    {
        // testを削除
        DB::table('game_platforms')
            ->where('id', 27)
            ->delete();
    }
}