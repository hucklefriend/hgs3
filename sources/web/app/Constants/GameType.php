<?php

namespace Hgs3\Constants;

class GameType
{
    const CONSUMER_GAME = 1;
    const CONSUMER_GAME_R18 = 2;
    const INDIE_GAME = 3;
    const INDIE_GAME_R18 = 4;

    public static function getSelectOptions()
    {
        return [
            self::CONSUMER_GAME     => 'コンシューマ',
            self::CONSUMER_GAME_R18 => 'コンシューマ(R-18)',
            self::INDIE_GAME        => 'インディー',
            self::INDIE_GAME        => 'インディー(R-18)',
        ];
    }
}