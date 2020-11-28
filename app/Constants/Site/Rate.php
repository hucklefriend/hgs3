<?php
/**
 * 対象年齢
 */

namespace Hgs3\Constants\Site;

class Rate
{
    const ALL = 0;
    const R15 = 15;
    const R18 = 18;

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
