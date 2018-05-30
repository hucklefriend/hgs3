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
        5  => '演技',
        6  => 'BGM',
        7  => 'SE',
        8  => '操作性',
        9  => '爽快感',
        10  => 'ゲームバランス',
        11 => 'ボリューム',
        12 => 'システム',
        13 => 'ゲーム性',
        14 => 'モーション',
        15 => '謎解き・パズル',
        16 => '隠し・おまけ・DLC',
        17 => 'エロ',
        18 => 'グロ',
        19 => 'バグ・通信障害',
        20 => 'サポート・運営'
    ];


    public static function getName($tagId)
    {
        return self::$tags[$tagId] ?? ' ';
    }
}