<?php
/**
 * 遊んだゲーム
 */

namespace Hgs3\Models\Orm;

class UserPlayedGame extends \Eloquent
{
    /**
     * ユーザーとゲームからデータを取得
     *
     * @param $userId
     * @param $gameId
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public static function findByUserAndGame($userId, $gameId)
    {
        return self::where('user_id', $userId)
            ->where('game_id', $gameId)
            ->first();
    }
}
