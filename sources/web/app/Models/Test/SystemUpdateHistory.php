<?php
/**
 * システム更新履歴
 */

namespace Hgs3\Models\Test;
use Hgs3\Models\User\FavoriteSite;
use Hgs3\Models\User\Follow;

class SystemUpdateHistory
{
    /**
     * テストデータ生成
     */
    public static function create($num = 100)
    {
        echo 'create system update history test data.'.PHP_EOL;

        for ($i = 0; $i < $num; $i++) {
            $orm = new \Hgs3\Models\Orm\SystemUpdateHistory();

            $year = rand(2017, 2018);
            $month = rand(1, 12);
            $day = rand(1, 28);
            $hour = rand(0, 23);
            $minute = rand(0, 59);

            $orm->title = 'システムを更新しました' . ($i + 1);
            $orm->update_at = sprintf('%d-%02d-%02d %02d:%02d', $year, $month, $day, $hour, $minute);
            $orm->detail =<<< DETAIL
システムを更新しました。
・○○を追加しました
・××を修正しました。
・××を修正しました。
・××を修正しました。
・××を修正しました。
DETAIL;

            $orm->save();
        }
    }
}