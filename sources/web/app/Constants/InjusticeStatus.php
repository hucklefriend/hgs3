<?php

namespace Hgs3\Constants;

class InjusticeStatus
{
    const NOT_DOING_ANYTHING = 0;   // 何もしていない
    const LOOKED = 1;               // 見ただけ
    const DEALT = 2;                // 対応済み
    const HOLD = 3;                 // 保留中
    const REJECT = 4;               // お断り
    const WAIT = 5;                 // 返答待ち

    private static $text = array(
        self::NOT_DOING_ANYTHING => '未確認',
        self::LOOKED             => '確認済み(見ただけ)',
        self::DEALT              => '対応済み',
        self::HOLD               => '保留中',
        self::REJECT             => '却下',
        self::WAIT               => '返答待ち',
    );

    public static function getText($id)
    {
        return self::$text[$id];
    }

    public static function getSelectOptions()
    {
        return self::$text;
    }
}
