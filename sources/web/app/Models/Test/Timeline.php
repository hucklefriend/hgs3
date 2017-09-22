<?php
/**
 * タイムラインのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Hgs3\Constants\TimelineType;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\UserFollow;

class Timeline
{
    /**
     * テストデータ生成
     *
     * @param $num
     */
    public static function create($num)
    {
        $tl_types = [
            TimelineType::NEW_GAME_SOFT,
            TimelineType::UPDATE_GAME_SOFT,
            TimelineType::FAVORITE_GAME,
            TimelineType::NEW_SITE,
            TimelineType::UPDATE_SITE,
            TimelineType::NEW_REVIEW,
            TimelineType::REVIEW_GOOD,
            TimelineType::NEW_USER_COMMUNITY_MEMBER,
            TimelineType::NEW_GAME_COMMUNITY_MEMBER,
            TimelineType::NEW_FOLLOWER,
        ];




        for ($i = 0; $i < $num; $i++) {

        }
    }
}