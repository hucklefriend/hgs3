<?php
/**
 * お知らせ
 */

namespace Hgs3\Models\Test;
use Hgs3\Constants\System\NoticeType;
use Hgs3\Models\User\FavoriteSite;
use Hgs3\Models\User\Follow;

class SystemNotice
{
    /**
     * テストデータ生成
     */
    public static function create($num = 100)
    {
        echo 'create system notice test data.'.PHP_EOL;

        for ($i = 0; $i < $num; $i++) {
            $orm = new \Hgs3\Models\Orm\SystemNotice();

            $year = rand(2017, 2018);
            $month = rand(1, 12);
            $day = rand(1, 28);
            $hour = rand(0, 23);
            $minute = rand(0, 59);

            $orm->title = 'お知らせです' . ($i + 1);
            $orm->open_at = sprintf('%d-%02d-%02d %02d:%02d', $year, $month, $day, $hour, $minute);
            $orm->close_at = sprintf('%d-%02d-%02d %02d:%02d', $year + 1, $month, $day, $hour, $minute);
            $orm->type = NoticeType::NORMAL;
            $orm->message =<<< DETAIL
システム更新のため、下記の日程でアクセスできなくなります。
XXXX/XX/XX XX:XX ～ XXXX/XX/XX XX:XX

開始直前に入力を行っていると消える恐れがありますので、
開始前には作業を行わないようお願いします。

よろしくお願いします。
DETAIL;

            $orm->save();
        }
    }
}