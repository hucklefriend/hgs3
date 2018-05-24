<?php
/**
 * プロフィールモデル
 */


namespace Hgs3\Models\User;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Support\Facades\DB;

class Profile
{
    /**
     * プロフィールトップで表示する各データ数を取得
     *
     * @param $userId
     * @return array
     */
    public static function getDataNum($userId)
    {
        return [
            'followNum'       => Follow::getFollowNum($userId),
            'followerNum'     => Follow::getFollowerNum($userId),
            'reviewNum'       => Orm\Review::getNumByUser($userId),
            'reviewDraftNum'  => Orm\ReviewDraft::getNumByUser($userId),
            'siteNum'         => Orm\Site::getNumByUser($userId),
            'favoriteSoftNum' => Orm\UserFavoriteSoft::getNumByUser($userId),
            'favoriteSiteNum' => Orm\UserFavoriteSite::getNumByUser($userId),
            'goodSiteNum'     => Orm\SiteGoodHistory::getNumByUser($userId)
        ];
    }

    /**
     * データ取得
     *
     * @param int $userId
     * @return array
     */
    public static function get($userId)
    {
        $data = [];

        // フォロー数
        $data['follow_num'] = 0;

        // フォロワー数
        $data['follower_num'] = 0;

        // 自分のサイト
        $data['sites'] = self::getSites($userId);

        // お気に入りゲーム
        $data['favoriteSofts'] = self::getFavoriteSofts($userId);

        // お気に入りサイト
        $data['favoriteSites'] = self::getFavoriteSites($userId);

        // レビュー
        $data['reviews'] = self::getReviews($userId);

        // いいねしたレビュー
        $data['goodReviews'] = self::getGoodReviews($userId);

        // 遊んだゲーム
        $data['playedSofts'] = self::getPlayedSofts($userId);


        // ゲームマスター
        $data['softs'] = self::getSoftMaster($data);
        // ユーザーマスター
        $data['users'] = self::getUserMaster($data);

        return $data;
    }

    /**
     * サイトを取得
     *
     * @param int $userId
     * @return mixed
     */
    private static function getSites($userId)
    {
        return Orm\Site::where('user_id', $userId)
            ->orderBy('id')
            ->take(3)
            ->get();
    }

    /**
     * お気に入りゲームを取得
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    private static function getFavoriteSofts($userId)
    {
        return Orm\UserFavoriteSoft::where('user_id', $userId)
            ->orderBy('id')
            ->take(5)
            ->get();
    }

    /**
     * レビューを取得
     *
     * @param int $userId
     * @return mixed
     */
    private static function getReviews($userId)
    {
        return Orm\Review::where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->take(3)
            ->get();
    }

    /**
     * いいねしたレビュー
     *
     * @param int $userId
     * @return array
     */
    private static function getGoodReviews($userId)
    {
        $result = [
            'order' => [],
            'reviews' => []
        ];

        $result['order'] = Orm\ReviewImpressionHistory::where('user_id', $userId)
            ->orderBy('good_at', 'DESC')
            ->take(3)
            ->get();

        if (empty($result['order'])) {
            return $result;
        }

        $reviews = Orm\Review::whereIn('id', array_pluck($result['order']->toArray(), 'review_id'))->get();
        foreach ($reviews as $r) {
            $result['reviews'][$r->id] = $r;
        }

        return $result;
    }

    /**
     * お気に入りサイトを取得
     *
     * @param $userId
     * @return array
     */
    private static function getFavoriteSites($userId)
    {
        $result = [
            'order' => [],
            'sites' => []
        ];

        $result['order'] = DB::table('user_favorite_sites')
            ->where('user_id', $userId)
            ->take(3)
            ->get()
            ->pluck('site_id');

        if (empty($result['order'])) {
            return $result;
        }

        $sites = Orm\Site::whereIn('id', $result['order'])->get();

        foreach ($sites as $s) {
            $result['sites'][$s->id] = $s;
        }

        return $result;
    }

    private static function getCommunities($userId)
    {
        // ゲームコミュニティのみ取得


    }

    /**
     * 遊んだゲーム
     *
     * @param $userId
     * @return \Illuminate\Support\Collection
     */
    private static function getPlayedSofts($userId)
    {
        return DB::table('user_played_softs')
            ->select(['game_id', 'comment'])
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->take(5)
            ->get();
    }

    /**
     * 必要なゲームマスターを取得
     *
     * @param array $data
     * @return array
     */
    private static function getSoftMaster(array $data)
    {
        $softIds = array_merge(
            array_pluck($data['favoriteSofts']->toArray(), 'soft_id'),
            array_pluck($data['reviews']->toArray(), 'soft_id'),
            array_pluck(array_pluck($data['goodReviews']['order']->toArray(), 'review_id'), 'soft_id'),
            $data['communities'],
            array_pluck($data['playedSofts']->toArray(), 'soft_id')
        );

        return Orm\GameSoft::getNameHash($softIds);
    }

    /**
     * 必要なユーザーマスターを取得
     *
     * @param array $data
     * @return
     */
    private static function getUserMaster(array $data)
    {
        $userIds = array_merge(
            array_pluck($data['favoriteSites']['sites'], 'user_id'),
            array_pluck($data['reviews']->toArray(), 'user_id'),
            array_pluck($data['goodReviews']['reviews'], 'user_id')
        );

        return User::getNameHash($userIds);
    }

    public static function changeMail()
    {

    }
}