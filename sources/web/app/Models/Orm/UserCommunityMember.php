<?php
/**
 * ORM user_community_member
 */

namespace Hgs3\Models\Orm;

class UserCommunityMember extends \Eloquent
{
    //
    protected $guarded = ['user_community_id', 'user_id'];

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
