<?php
/**
 * 対象年齢
 */

namespace Hgs3\Constants\Site;

class ApprovalStatus
{
    const WAIT = 0;
    const REJECT = 1;
    const OK = 2;

    private static $text = [
        self::WAIT   => '承認待ち',
        self::REJECT => '登録NG',
        self::OK     => '公開中'
    ];

    /**
     * テキストを取得
     *
     * @param $id
     * @return string
     */
    public static function getText($id)
    {
        return self::$text[$id];
    }
}
