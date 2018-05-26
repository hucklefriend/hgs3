<?php
/*
 * レビューのタグ
 */

namespace Hgs3\Constants\Review;

class Tag
{
    const POINT_RATE = 2;

    public static $tags = [
        1  => 'グラフィック',
        2  => '世界観',
        3  => 'ストーリー',
        4  => 'キャラクター',
        5  => 'BGM',
        6  => 'SE',
        7  => '操作性',
        8  => '爽快感',
        9  => 'ゲームバランス',
        10 => 'ボリューム',
        11 => 'システム',
        12 => 'ゲーム性',
        13 => 'エロ',
        14 => 'グロ',
        15 => '役者・声優',
        16 => 'モーション',
        17 => '謎解き',
        18 => 'テンポ',
        19 => 'バグ・通信障害',
        20 => 'サポート・運営'
    ];


    public static function getName($tagId)
    {
        return self::$tags[$tagId] ?? ' ';
    }
}