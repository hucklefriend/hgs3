<?php
/**
 * 公開範囲
 */

namespace Hgs3\Constants\Site;

class OpenType
{
    const NONE = 0;
    const ALL = 1;
    const USER = 2;

    private static $text = [
        self::NONE => '非公開',
        self::ALL  => '全体',
        self::USER => 'H.G.N.登録ユーザーのみ'
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
