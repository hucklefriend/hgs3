<?php
/**
 * ショップ
 */

namespace Hgs3\Constants\Game;

class Shop
{
    const AMAZON = 1;
    const STEAM = 11;
    const PLAY_STATION_STORE = 12;
    const MICROSOFT_STORE = 13;
    const NINTENDO_STORE = 14;
    const NINTENDO_E_SHOP = 15;
    const DMM_GAMES = 16;
    const APP_STORE = 31;
    const GOOGLE_PLAY = 32;

    private static $names = [
        self::AMAZON             => 'Amazon',
        self::STEAM              => 'Steam',
        self::PLAY_STATION_STORE => 'PlayStation Store',
        self::MICROSOFT_STORE    => 'Microsoft ストア',
        self::NINTENDO_STORE     => 'My Nintendo Store',
        self::NINTENDO_E_SHOP    => 'ニンテンドーeショップ',
        self::DMM_GAMES          => 'DMM GAMES',
        self::APP_STORE          => 'App Store',
        self::GOOGLE_PLAY        => 'Google Play',
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