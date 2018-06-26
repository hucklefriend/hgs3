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
        $manualMethod = 'manual' . $date;
        if (method_exists(new self(), $manualMethod)) {
            self::$manualMethod();
        } else {
            echo 'nothing official site manual update.' . PHP_EOL;
        }

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
        $path = storage_path('master/' . $date . '/official_site/update.php');
        if (!File::isFile($path)) {
            echo 'nothing official site update data.' . PHP_EOL;
            return;
        }

        $officialSites = include($path);

        foreach ($officialSites as $s) {
            DB::table('game_official_sites')
                ->where('soft_id', $s['soft_id'])
                ->where('url', $s['url'])
                ->update($s);
        }

        unset($softs);
    }

    /**
     * 手動設定
     */
    private static function manual20180606()
    {
        DB::table('game_official_sites')
            ->where('soft_id', 41)
            ->where('url', 'http://www.jp.playstation.com/software/title/uljm05413.html')
            ->delete();
        DB::table('game_official_sites')
            ->where('soft_id', 50)
            ->where('url', 'http://www.jp.playstation.com/software/title/slps01290.html')
            ->delete();
        DB::table('game_official_sites')
            ->where('soft_id', 54)
            ->where('url', 'http://www.jp.playstation.com/software/title/scps19305.html')
            ->delete();
        DB::table('game_official_sites')
            ->where('soft_id', 82)
            ->whereIn('url', ['http://www.jp.playstation.com/software/title/slps01230.html', 'http://www.jp.playstation.com/software/title/jp0082npjj00455_000000000000000001.html'])
            ->delete();

    }
}