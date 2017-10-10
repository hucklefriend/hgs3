<?php
/**
 * 対象年齢
 */

namespace Hgs3\Constants\Site;

class Rate
{
    const ALL = 1;
    const R15 = 2;
    const R18 = 3;

    private static $text = [
        self::ALL => '全年齢',
        self::R15 => 'R-15',
        self::R18 => 'R-18'
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
