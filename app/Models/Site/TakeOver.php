<?php
/**
 * 引き継ぎ
 */

namespace Hgs3\Models\Site;

use Hgs3\Models\MongoDB\Collection;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TakeOver
{
    /**
     * H.G.S.で登録していたサイトがあるか
     *
     * @param $userId
     * @return bool
     */
    public static function hasHgs2Site(User $user)
    {
        $hgs2UserId = $user->getHgs2UserId();
        if ($hgs2UserId == null) {
            return false;
        }

        return DB::table('hgs2.hgs_u_site')
                ->where('user_id', $hgs2UserId)
                ->count('id') > 0;
    }

    /**
     * H.G.S.2のサイトオーナーか？
     *
     * @param User $user
     * @param $hgs2SiteId
     * @return bool
     */
    public static function isOwner(User $user, $hgs2SiteId)
    {
        $hgs2UserId = $user->getHgs2UserId();
        if ($hgs2UserId == null) {
            return false;
        }

        return DB::table('hgs2.hgs_u_site')
            ->where('user_id', $hgs2UserId)
            ->where('id', $hgs2SiteId)
            ->count('id') > 0;
    }

    /**
     * H.G.S.で登録していたサイトを取得
     *
     * @param User $user
     * @return array|\Illuminate\Support\Collection
     */
    public static function getHgs2Sites(User $user)
    {
        $hgs2UserId = $user->getHgs2UserId();
        if ($hgs2UserId == null) {
            return array();
        }

        return DB::table('hgs2.hgs_u_site')
                ->where('user_id', $hgs2UserId)
                ->get();
    }

    /**
     * H.G.S.のサイト情報を取得
     *
     * @param User $user
     * @param $hgs2SiteId
     * @return Orm\Site|null
     */
    public static function getHgs2Site(User $user, $hgs2SiteId)
    {
        $hgs2UserId = $user->getHgs2UserId();
        if ($hgs2UserId == null) {
            return null;
        }

        $hgs2Site = DB::table('hgs2.hgs_u_site')
                ->where('user_id', $hgs2UserId)
                ->where('id', $hgs2SiteId)
                ->first();

        if (empty($hgs2Site)) {
            return null;
        }

        $handleGames = DB::table('hgs2.hgs_u_site_handle_game')
            ->select(array('soft_id'))
            ->where('site_id', $hgs2SiteId)
            ->pluck('soft_id')
            ->toArray();

        $site = new Orm\Site;
        $site->name = $hgs2Site->site_name;
        $site->url = $hgs2Site->url;
        $site->list_banner_upload_flag = empty($hgs2Site->banner_url) ? 0 : 1;
        $site->list_banner_url = $hgs2Site->banner_url;
        $site->presentation = $hgs2Site->presentation;
        $site->handle_soft = implode(',', $handleGames);
        $site->rate = $hgs2Site->rate;
        $site->gender = $hgs2Site->gender;
        $site->main_contents_id = $hgs2Site->main_contents;
        $site->in_count = $hgs2Site->in;
        $site->out_count = $hgs2Site->out;
        $site->registered_timestamp = $hgs2Site->registered_date;

        return $site;
    }
}