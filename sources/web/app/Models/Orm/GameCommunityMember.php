<?php
/**
 * ORM: game_community_members
 */

namespace Hgs3\Models\Orm;

use Illuminate\Database\Eloquent\Model;

class GameCommunityMember extends \Eloquent
{
    /**
     * 特定ユーザーの参加コミュニティ数を取得
     *
     * @param $userId
     * @return int
     */
    public static function getNumByUser($userId)
    {
        return self::where('user_id', $userId)
            ->count('user_id');
    }
}