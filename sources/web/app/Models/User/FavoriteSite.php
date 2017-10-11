<?php
/**
 * お気に入りゲームモデル
 */

namespace Hgs3\Models\User;
use Illuminate\Support\Facades\DB;

class FavoriteSite
{
    /**
     * 登録
     *
     * @param $userId
     * @param $siteId
     */
    public function add($userId, $siteId)
    {
        $sql =<<< SQL
INSERT IGNORE INTO user_favorite_sites
(user_id, site_id, created_at, updated_at)
VALUES (?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
SQL;

        DB::insert($sql, [$userId, $siteId]);
    }

    /**
     * 削除
     *
     * @param $userId
     * @param $siteId
     */
    public function remove($userId, $siteId)
    {
        DB::table('user_favorite_sites')
            ->where('user_id', $userId)
            ->where('site_id', $siteId)
            ->delete();
    }

    /**
     * お気に入り登録済みか
     *
     * @param $userId
     * @param $siteId
     * @return bool
     */
    public function isFavorite($userId, $siteId)
    {
        return DB::table('user_favorite_sites')
            ->where('user_id', $userId)
            ->where('site_id', $siteId)
            ->count('user_id') > 0;
    }

    /**
     * ユーザーを取得
     *
     * @param $siteId
     * @return \Illuminate\Support\Collection
     */
    public function getOldUsers($siteId)
    {
        return DB::table('user_favorite_sites')
            ->where('site_id', $siteId)
            ->orderBy('id')
            ->take(5)
            ->get();
    }

    /**
     * 一覧を取得
     *
     * @param $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get($userId)
    {
        return DB::table('user_favorite_sites')
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->paginate(10);
    }
}