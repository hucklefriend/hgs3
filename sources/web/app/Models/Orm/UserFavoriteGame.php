<?php
/**
 * お気に入りゲーム
 */

namespace Hgs3\Models\Orm;

class UserFavoriteGame extends \Eloquent
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
