<?php
/**
 * 遊んだゲームモデル
 */

namespace Hgs3\Models\User;
use Illuminate\Support\Facades\DB;

class PlayedGame
{
    /**
     * お気に入り登録済みか
     *
     * @param $userId
     * @param $gameId
     * @return bool
     */
    public function isPlayed($userId, $gameId)
    {
        return DB::table('user_played_games')
            ->where('user_id', $userId)
            ->where('game_id', $gameId)
            ->count('user_id') > 0;
    }
}