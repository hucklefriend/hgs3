<?php
/**
 * アイコンのボーダー種別
 */

namespace Hgs3\Constants;


class IconRoundType
{
    // 定数を変えたらgetValidationInも変えてください
    const NONE = 0;
    const ROUNDED = 1;
    const CIRCLE = 2;

    /**
     * クラスを取得
     *
     * @param $type
     * @return string
     */
    public static function getClass($type)
    {
        switch ($type) {
            case self::ROUNDED:
                return 'rounded';
            case self::CIRCLE:
                return 'rounded-circle';
        }

        return '';
    }

    /**
     * バリデーション用の値を取得
     *
     * @return string
     */
    public static function getValidationIn()
    {
        // 直書き
        return '0,1,2';
    }
}