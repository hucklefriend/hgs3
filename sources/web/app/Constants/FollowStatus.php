<?php

namespace Hgs3\Constants;

class FollowStatus
{
    const NONE = 0;
    const FOLLOW = 1;
    const FOLLOWER = 2;
    const MUTUAL_FOLLOW = 3;

    public static function getIcon($followStatus)
    {
        $icon = '';

        switch ($followStatus) {
            case self::FOLLOW:
                break;
            case self::FOLLOWER:
                break;
            case self::MUTUAL_FOLLOW:
                $icon = '<i class="far fa-handshake"></i>';
                break;
        }

        return $icon;
    }
}