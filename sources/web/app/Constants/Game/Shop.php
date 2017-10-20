<?php
/**
 * ショップ
 */

namespace Hgs3\Constants\Game;

class Shop
{
    const AMAZON = 1;
    const STEAM = 2;
    const PLAY_STATION_STORE = 3;
    const MICROSOFT_STORE = 4;
    const NINTENDO_STORE = 5;

    private static $names = [
        self::AMAZON => 'Amazon',
        self::STEAM => 'Steam',
        self::PLAY_STATION_STORE => 'PlayStation Store',
        self::MICROSOFT_STORE => 'Microsoft ストア',
        self::NINTENDO_STORE => 'My Nintendo Store'
    ];

    /**
     * 名称からIDを取得
     *
     * @param $name
     * @return int|null|string
     */
    public static function getIdByName($name)
    {
        foreach (self::$names as $id => $n) {
            if (strtolower($n) == strtolower($name)) {
                return $id;
            }
        }

        return null;
    }
}