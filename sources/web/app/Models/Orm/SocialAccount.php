<?php
/**
 * ORM: sites
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    /**
     * 登録済みか？
     *
     * @param $socialSiteId
     * @param $socialUserId
     * @return bool
     */
    public function isRegistered($socialSiteId, $socialUserId)
    {
        return self::where('social_user_id', $socialUserId)
            ->where('social_site_id', $socialSiteId)
            ->count() > 0;
    }

    /**
     * ユーザーIDを取得
     *
     * @param $socialSiteId
     * @param $socialUserId
     * @return null|int
     */
    public function getUserId($socialSiteId, $socialUserId)
    {
        $orm = self::where('social_user_id', $socialUserId)
                ->where('social_site_id', $socialSiteId)
                ->first(['user_id']);

        if (empty($orm)) {
            return null;
        }

        return $orm->user_id;
    }
}
