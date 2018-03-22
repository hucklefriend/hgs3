<?php
/**
 * 公式サイトインポート
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class OfficialSite extends MasterImportAbstract
{
    /**
     * インポート
     */
    public static function import($date)
    {
        if ($date == '20180401') {
            // ローカル環境でのみ実行
            //Orm\GameOfficialSite::truncate();
            //self::insertFromPackage();
        }

        // 既存データのアップデート
        self::update($date);

        $path = storage_path('master/' . $date . '/official_site');
        if (!File::isDirectory($path)) {
            echo 'nothing official site new data.' . PHP_EOL;
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
                    $officialSite = new Orm\GameOfficialSite($row);
                    $officialSite->soft_id = $row['soft_id'];
                    $officialSite->url = $row['url'];
                    $officialSite->title = $row['title'];
                    $officialSite->priority = $row['priority'];
                    $officialSite->save2();
                }
            }
        }

        $manualMethod = 'manual' . $date;
        if (method_exists(new self(), $manualMethod)) {
            self::$manualMethod();
        } else {
            echo 'nothing official site manual update.' . PHP_EOL;
        }
    }

    /**
     * データの更新
     *
     * @param $date
     */
    private static function update($date)
    {
        $path = storage_path('master/' . $date . '/official_site/update.php');
        if (!File::isFile($path)) {
            echo 'nothing official site update data.' . PHP_EOL;
            return;
        }

        $officialSites = include($path);

        foreach ($officialSites as $s) {
            DB::table('game_official_site')
                ->where('id', $s['id'])
                ->update($s);
        }

        unset($softs);
    }

    /**
     * 2018.4.1
     *
     * @throws \Exception
     */
    private static function insertFromPackage()
    {
        // 既存テーブルからデータ移行
        $softs = self::getSoftHash();
        foreach ($softs as $name => $softId) {
            // パッケージを取得
            $packages = Orm\GamePackageLink::where('soft_id', $softId)
                ->get()->pluck('package_id');

            if ($packages->isNotEmpty()) {
                $urls = Orm\GamePackage::select('url')
                    ->whereIn('id', $packages->toArray())
                    ->groupBy('url')
                    ->get()
                    ->pluck('url');

                $p = 1;
                foreach ($urls as $url) {
                    if (empty($url)) {
                        continue;
                    }
                    $officialSite = new Orm\GameOfficialSite();
                    $officialSite->soft_id = $softId;
                    $officialSite->title = '公式';
                    $officialSite->url = $url;
                    $officialSite->priority = $p++;
                    $officialSite->save();
                }
            }
        }
    }
}