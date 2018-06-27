<?php
/**
 * ORM: sites
 */

namespace Hgs3\Models\Orm;

use Hgs3\Constants\SocialSite;

class SocialAccount extends \Eloquent
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

    /**
     * ソーシャルサイトのユーザーIDからデータ取得
     *
     * @param $socialSiteId
     * @param $socialUserId
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function findBySocialUserId($socialSiteId, $socialUserId)
    {
        return self::where('social_user_id', $socialUserId)
            ->where('social_site_id', $socialSiteId)
            ->first();
    }

    /**
     * HGNのユーザーIDからデータを取得
     *
     * @param $socialSiteId
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function findByUserId($socialSiteId, $userId)
    {
        return self::where('user_id', $userId)
            ->where('social_site_id', $socialSiteId)
            ->first();
    }

    /**
     * URLを取得
     *
     * @return string
     */
    public function getUrl()
    {
        $url = '';

        switch ($this->social_site_id) {
            case SocialSite::TWITTER:
                $url = 'https://twitter.com/' . $this->nickname . '/';
                break;
            case SocialSite::FACEBOOK:
            case SocialSite::GITHUB:
            case SocialSite::GOOGLE_PLUS:
            case SocialSite::PIXIV:
                $url = $this->url;
                break;
        }

        return $url;
    }
}
