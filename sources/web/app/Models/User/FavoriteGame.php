<?php
/**
 * お気に入りゲームモデル
 */

namespace Hgs3\Models\User;
use Hgs3\Models\Timeline;
use Hgs3\User;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FavoriteGame
{
    /**
     * 登録
     *
     * @param User $user
     * @param Orm\GameSoft $game
     * @return bool
     */
    public function add(User $user, Orm\GameSoft $game)
    {
        $sql =<<< SQL
INSERT IGNORE INTO user_favorite_games
(user_id, game_id, rank, created_at, updated_at)
VALUES (?, ?, null, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
SQL;

        DB::beginTransaction();
        try {
            DB::insert($sql, [$user->id, $game->id]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        // TODO 追加->取り消しの繰り返しをさせない
        Timeline\FavoriteGame::addFavoriteGameText($game->id, $game->name, $user->id, $user->name);
        Timeline\User::addAddFavoriteGameText($user->id, $user->name, $game->id, $game->name);

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