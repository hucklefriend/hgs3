<?php
/**
 * 遊んだゲーム
 */

namespace Hgs3\Models\Orm;

class UserPlayedSoft extends \Eloquent
{
    /**
     * ユーザーとゲームからデータを取得
     *
     * @param int $userId
     * @param int $softId
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public static function findByUserAndGame($userId, $softId)
    {
        return self::where('user_id', $userId)
            ->where('soft_id', $softId)
            ->first();
    }
}
