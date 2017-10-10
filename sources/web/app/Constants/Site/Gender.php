<?php
/**
 * 性別傾向
 */

namespace Hgs3\Constants\Site;

class Gender
{
    const NONE = 1;
    const MALE = 2;
    const FEMALE = 3;

    private static $text = [
        self::NONE   => 'なし',
        self::MALE   => '男性向け',
        self::FEMALE => '女性向け'
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
