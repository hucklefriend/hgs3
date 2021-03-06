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
    const EGG = 17;
    const XBOX_STORE = 18;
    const APP_STORE = 31;
    const GOOGLE_PLAY = 32;
    const SQM = 33;
    const GETCHU = 41;
    const DL_SITE = 42;
    const DMM = 43;
    const DMM_R18 = 44;

    private static $names = [
        self::AMAZON             => 'Amazon',
        self::STEAM              => 'Steam',
        self::PLAY_STATION_STORE => 'PlayStation Store',
        self::MICROSOFT_STORE    => 'Microsoft ストア',
        self::NINTENDO_STORE     => 'My Nintendo Store',
        self::NINTENDO_E_SHOP    => 'Nintendo eShop',
        self::DMM_GAMES          => 'DMM GAMES',
        self::EGG                => 'EGG',
        self::XBOX_STORE         => 'XBOX ストア',
        self::APP_STORE          => 'App Store',
        self::GOOGLE_PLAY        => 'Google Play',
        self::SQM                => 'スクエニマーケット',
        self::GETCHU             => 'Getchu.com',
        self::DL_SITE            => 'DLsite',
        self::DMM                => 'DMM.com',
        self::DMM_R18            => 'DMM.R18',
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

    /**
     * 名称を取得
     *
     * @param $id
     * @return string
     */
    public static function getName($id)
    {
        return self::$names[$id] ?? '';
    }

    /**
     * Font awesomeのマークを取得
     *
     * @param $id
     * @return string
     */
    public static function getMark($id)
    {
        $mark = '';

        switch ($id) {
            case self::AMAZON:
                $mark = '<i class="fab fa-amazon"></i>';
                break;
            case self::STEAM:
                $mark = '<i class="fab fa-steam"></i>';
                break;
            case self::PLAY_STATION_STORE:
                $mark = '<i class="fab fa-playstation"></i>';
                break;
            case self::APP_STORE:
                $mark = '<i class="fab fa-apple"></i>';
                break;
            case self::GOOGLE_PLAY:
                $mark = '<i class="fab fa-google-play"></i>';
                break;
            case self::MICROSOFT_STORE:
                $mark = '<i class="fab fa-microsoft"></i>';
                break;
            case self::NINTENDO_STORE:
            case self::NINTENDO_E_SHOP:
                $mark = '<i class="fab fa-nintendo-switch"></i>';
                break;
            case self::XBOX_STORE:
                $mark = '<i class="fab fa-xbox"></i>';
                break;
        }

        return $mark;
    }
}