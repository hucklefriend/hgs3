<?php
/**
 * 性別傾向
 */

namespace Hgs3\Constants\Site;

class Gender
{
    const NONE = 0;
    const MALE = 1;
    const FEMALE = 2;

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
        return self::$text[$id] ?? '';
    }
}
