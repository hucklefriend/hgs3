<?php
/**
 * お気に入りサイト
 */

namespace Hgs3\Models\Orm;

class UserFavoriteSite extends \Eloquent
{
    /**
     * 特定ユーザーのデータ数を取得
     *
     * @param $userId
     * @return int
     */
    public static function getNumByUser($userId)
    {
        return self::where('user_id', $userId)
            ->count('id');
    }
}
