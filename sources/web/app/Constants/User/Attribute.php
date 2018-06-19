<?php
/**
 * ユーザー属性
 */

namespace Hgs3\Constants\User;

class Attribute
{
    const PLAYER = 1;
    const ILLUSTRATOR = 2;
    const SCENARIO_WRITER = 3;
    const PERFORMER = 4;
    const COMPOSER = 5;
    const LIVE_PLAYER = 6;
    const COSTUME_PLAYER = 7;
    const SELLER = 8;
    const GAME_CREATOR = 9;
    const CREATOR = 10;

    public static $text = [
        self::PLAYER => '遊ぶ人',
        self::ILLUSTRATOR => '絵を描く人',
        self::SCENARIO_WRITER => '物語を書く人',
        self::PERFORMER => '演奏する人',
        self::COMPOSER => '曲を作る人',
        self::LIVE_PLAYER => '実況する人',
        self::COSTUME_PLAYER => 'コスプレする人',
        self::SELLER => '販売する人',
        self::GAME_CREATOR => 'ゲームを開発する人',
        self::CREATOR => '創作する人'
    ];
}