<?php
/**
 * メインコンテンツ
 */

namespace Hgs3\Constants\Site;

class MainContents
{
    const WALKTHROUGH = 1;
    const ILLUSTRATION = 2;
    const TEXT = 3;
    const CREATION = 4;
    const SNS = 5;
    const NEWS = 6;
    const OTHER = 7;

    private static $text = [
        self::WALKTHROUGH  => '攻略',
        self::ILLUSTRATION => 'イラスト/漫画',
        self::TEXT         => '小説/テキスト',
        self::CREATION     => 'その他創作',
        self::SNS          => 'SNS/同盟/検索エンジン/ウェブ・リング',
        self::NEWS         => 'ニュース/情報',
        self::OTHER        => 'その他',
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
