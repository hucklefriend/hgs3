<?php
/*
 * レビューのタグ
 */

namespace Hgs3\Constants\Review;

class Fear
{
    public static $data = [
        0 => '怖いところなし',
        1 => 'ちょっと怖い部分があったような気がする',
        2 => '少し怖かった',
        3 => '普通に怖かった',
        4 => 'けっこう怖かった',
        5 => '怖すぎた',
        6 => 'あまりにも怖すぎてもうやりたくない',
    ];

    public static function getMaxPoint()
    {
        return 6;
    }
}