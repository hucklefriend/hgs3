<?php
/**
 * ゲーム会社インポート
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
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

                $c = Orm\GameMaker::find($data['id']);
                if ($c == null) {
                    $com = new Orm\GameMaker($data);
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
            $company = Orm\GameMaker::find($c['id']);

            $data = $c;
            unset($data['id']);
            $company->update($data);

            unset($data);
            unset($company);
        }

        unset($companies);
    }

    /**
     * 手動設定
     */
    private static function manual20180604()
    {
        DB::table('game_companies')
            ->whereIn('id', [24, 55, 154, 63, 138, 26, 74, 155, 89, 122])
            ->delete();

        DB::table('game_companies')
            ->whereIn('id', [94, 73, 134, 141, 148, 84, 71, 78, 85, 93, 92, 77, 144, 87, 147, 91,
                145, 116, 72, 90, 139, 171, 86, 132, 157, 88, 169, 149, 79, 76, 82, 80, 143, 83, 156, 81, 70, 75])
            ->update(['is_adult_url' => 1]);



        // SUNSOFTを統合

        // TETRATECH間違ってない？
        // ノクターンってB&A？
    }
}