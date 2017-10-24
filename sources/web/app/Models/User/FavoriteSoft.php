<?php
/**
 * お気に入りゲームモデル
 */

namespace Hgs3\Models\User;
use Hgs3\Models\Timeline;
use Hgs3\Models\User;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FavoriteSoft
{
    /**
     * 登録
     *
     * @param User $user
     * @param Orm\GameSoft $soft
     * @return bool
     */
    public static function add(User $user, Orm\GameSoft $soft)
    {
        $sql =<<< SQL
INSERT IGNORE INTO user_favorite_softs
(user_id, soft_id, rank, created_at, updated_at)
VALUES (?, ?, null, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
SQL;

        DB::beginTransaction();
        try {
            DB::insert($sql, [$user->id, $soft->id]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        // TODO 追加->取り消しの繰り返しをさせない
        Timeline\FavoriteSoft::addFavoriteSoftText($soft, $user);
        Timeline\FollowUser::addAddFavoriteSoftText($user, $soft);

        return true;
    }

    /**
     * 削除
     *
     * @param User $user
     * @param Orm\GameSoft $soft
     */
    public static function remove(User $user, Orm\GameSoft $soft)
    {
        DB::table('user_favorite_softs')
            ->where('user_id', $user->id)
            ->where('soft_id', $soft->id)
            ->delete();
    }

    /**
     * お気に入り登録済みか
     *
     * @param int $userId
     * @param int $softId
     * @return bool
     */
    public function isFavorite($userId, $softId)
    {
        return DB::table('user_favorite_softs')
            ->where('user_id', $userId)
            ->where('soft_id', $softId)
            ->count('user_id') > 0;
    }

    /**
     * 取得
     *
     * @param int $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get($userId)
    {
        return DB::table('user_favorite_softs')
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->paginate(20);
    }
}