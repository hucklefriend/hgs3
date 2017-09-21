<?php
/**
 * お気に入りゲームモデル
 */

namespace Hgs3\Models\User;
use Hgs3\Models\Timeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FavoriteGame
{
    /**
     * 登録
     *
     * @param int $userId
     * @param int $gameId
     * @return bool
     */
    public function add($userId, $gameId)
    {
        $sql =<<< SQL
INSERT IGNORE INTO user_favorite_games
(user_id, game_id, rank, created_at, updated_at)
VALUES (?, ?, null, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
SQL;

        DB::beginTransaction();
        try {
            DB::insert($sql, [$userId, $gameId]);

            Timeline::addFavoriteGameText($gameId, null, $userId, null);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return true;
    }

    /**
     * 削除
     *
     * @param $userId
     * @param $gameId
     */
    public function remove($userId, $gameId)
    {
        DB::table('user_favorite_games')
            ->where('user_id', $userId)
            ->where('game_id', $gameId)
            ->delete();
    }

    /**
     * お気に入り登録済みか
     *
     * @param $userId
     * @param $gameId
     * @return bool
     */
    public function isFavorite($userId, $gameId)
    {
        return DB::table('user_favorite_games')
            ->where('user_id', $userId)
            ->where('game_id', $gameId)
            ->count('user_id') > 0;
    }
}