<?php
/**
 * お気に入りゲームモデル
 */

namespace Hgs3\Models\User;

use Hgs3\Models\User;
use Hgs3\Models\Orm;
use Hgs3\Models\Timeline;
use Illuminate\Support\Facades\DB;

class FavoriteSite
{
    /**
     * 登録
     *
     * @param User $user
     * @param Orm\site $site
     */
    public static function add(User $user, Orm\Site $site)
    {
        $sql =<<< SQL
INSERT IGNORE INTO user_favorite_sites
(user_id, site_id, created_at, updated_at)
VALUES (?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
SQL;

        DB::insert($sql, [$user->id, $site->id]);

        $webmaster = User::find($site->user_id);
        if ($webmaster) {
            Timeline\ToMe::addSiteFavoriteText($webmaster, $site, $user);
        }
    }

    /**
     * 削除
     *
     * @param User $user
     * @param Orm\Site $site
     */
    public static function remove(User $user, Orm\Site $site)
    {
        DB::table('user_favorite_sites')
            ->where('user_id', $user->id)
            ->where('site_id', $site->id)
            ->delete();
    }

    /**
     * お気に入り登録済みか
     *
     * @param int $userId
     * @param int $siteId
     * @return bool
     */
    public static function isFavorite($userId, $siteId)
    {
        return DB::table('user_favorite_sites')
            ->where('user_id', $userId)
            ->where('site_id', $siteId)
            ->count('user_id') > 0;
    }

    /**
     * ユーザーを取得
     *
     * @param int $siteId
     * @return \Illuminate\Support\Collection
     */
    public static function getOldUsers($siteId)
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
     * @param int $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function get($userId)
    {
        return DB::table('user_favorite_sites')
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->paginate(10);
    }
}