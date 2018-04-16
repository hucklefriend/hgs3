<?php
/**
 * ゲーム会社インポート
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\File;

class Company extends MasterImportAbstract
{
    /**
     * 会社マスターのインポート
     *
     * @param $date
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function import($date)
    {
        // 新規データの追加
        $path = storage_path('master/' . $date . '/company');
        if (!File::isDirectory($path)) {
            echo 'nothing company new data.' . PHP_EOL;
        } else {
            $files = File::files($path);
            foreach ($files as $filePath) {
                if (ends_with($filePath, 'update.php')) {
                    continue;
                }

                echo 'loading ' . $filePath . PHP_EOL;
                $data = \GuzzleHttp\json_decode(File::get($filePath), true);

                $c = Orm\GameCompany::find($data['id']);
                if ($c == null) {
                    $com = new Orm\GameCompany($data);
                    $com->save();
                    unset($com);
                }


                unset($data);
            }
        }

        // 既存データのアップデート
        self::update($date);


        $manualMethod = 'manual' . $date;
        if (method_exists(new self(), $manualMethod)) {
            self::$manualMethod();
        } else {
            echo 'nothing company manual update.' . PHP_EOL;
        }
    }

    /**
     * データの更新
     *
     * @param int $date
     */
    private static function update($date)
    {
        $path = storage_path('master/' . $date . '/company/update.php');
        if (!File::isFile($path)) {
            echo 'nothing company update data.' . PHP_EOL;
            return;
        }

        $companies = include($path);

        foreach ($companies as $c) {
            $company = Orm\GameCompany::find($c['id']);

            $data = $c;
            unset($data['id']);
            $company->update($data);

            unset($data);
            unset($company);
        }

        unset($companies);
    }
}