<?php
/*
 * レビューのタグ
 */

namespace Hgs3\Constants\Review;

class Tag
{
    public static $tags = [
        1  => 'グラフィック',
        2  => '世界観',
        3  => 'ストーリー',
        4  => 'キャラクター',
        5  => 'サウンド',
        6  => '操作性',
        7  => '爽快感',
        8  => 'ゲームバランス',
        9  => 'ボリューム',
        10 => 'システム',
        11 => 'ゲーム性',
        12 => 'エロ',
        13 => 'グロ',
        14 => '',
        15 => ''
    ];


    public static function getName($tagId)
    {
        return self::$tags[$tagId] ?? ' ';
    }
}