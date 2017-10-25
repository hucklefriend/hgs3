<?php
/**
 * 遊んだゲームモデル
 */

namespace Hgs3\Models\User;
use Illuminate\Support\Facades\DB;

class PlayedSoft
{
    /**
     * 遊んだゲーム登録済みか
     *
     * @param int $userId
     * @param int $softId
     * @return bool
     */
    public function isPlayed($userId, $softId)
    {
        return DB::table('user_played_softs')
            ->where('user_id', $userId)
            ->where('soft_id', $softId)
            ->count('user_id') > 0;
    }
}