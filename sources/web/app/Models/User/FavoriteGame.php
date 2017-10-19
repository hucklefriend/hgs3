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

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        // TODO 追加->取り消しの繰り返しをさせない
        Timeline\Game::addFavoriteGameText($gameId, null, $userId, null);
        Timeline\User::addAddFavoriteGameText($userId, null, $gameId, null);

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

    /**
     * 取得
     *
     * @param $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get($userId)
    {
        return DB::table('user_favorite_games')
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->paginate(20);
    }
}