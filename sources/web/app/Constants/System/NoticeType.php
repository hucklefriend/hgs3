<?php
/**
 * お知らせ種別
 */

namespace Hgs3\Constants\System;

class NoticeType
{
    const NORMAL = 0;
    const IMPORTANT = 1;

    private static $text = [
        self::NORMAL    => '通常',
        self::IMPORTANT => '重要',
    ];

    /**
     * データを取得
     *
     * @return array
     */
    public static function getData()
    {
        return self::$text;
    }
}