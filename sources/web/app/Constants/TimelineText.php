<?php
/**
 * タイムラインテキスト定数
 */

namespace Hgs3\Constants;

class TimelineText
{
    const TLT_ = 0;
    const TLT_NEW_GAME_SOFT = 1;
    const TLT_UPDATE_GAME_SOFT = 2;

    private static $instance = null;
    private $text = [];

    /**
     * TimelineText constructor.
     */
    private function __construct()
    {
        $this->text = [
            // ゲームソフト
            self::TLT_NEW_GAME_SOFT    => '「<a href="%s">%s</a>」が追加されました。',
            self::TLT_UPDATE_GAME_SOFT => '「<a href="%s">%s</a>」が追加されました。',

            // レビュー
            self::TLT_ => '<a href="%s">%sさん</a>が<a href="%s">%s</a>に参加しました',
            self::TLT_ => '%sに',
            self::TLT_ => '「%s」',
            self::TLT_ => '',
            self::TLT_ => '',
            self::TLT_ => '',
            self::TLT_ => '',
            self::TLT_ => '',
            self::TLT_ => '',
            self::TLT_ => '',
            self::TLT_ => '',
        ];
    }

    /**
     * インスタンスを取得
     *
     * @return TimelineText
     */
    public static function getInstance() : TimelineText
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * テキストを取得
     *
     * @param $id
     * @param array $param
     * @return string
     */
    public function getText($id, $param = [])
    {
        return vsprintf($this->text[$id], $param);
    }
}