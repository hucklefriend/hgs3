<?php
/**
 * メッセージ
 */

namespace Hgs3\Models\Orm;

class Message extends \Eloquent
{
    protected $guarded = ['id'];
    /**
     * 特定ユーザーのデータ数を取得
     *
     * @param $userId
     * @return int
     */
    public static function getNumByUser($userId)
    {
        return self::where('to_user_id', $userId)
            ->count('id');
    }
}
