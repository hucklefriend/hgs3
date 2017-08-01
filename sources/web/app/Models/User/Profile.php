<?php
/**
 * プロフィールモデル
 */


namespace Hgs3\Models\User;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\Review;
use Hgs3\Models\Orm\ReviewGoodHistory;
use Hgs3\Models\Orm\Site;
use Hgs3\Models\Orm\UserFavoriteGame;
use Hgs3\User;
use Illuminate\Support\Facades\DB;

class Profile
{
    /**
     * データ取得
     *
     * @param $userId
     */
    public function get($userId)
    {
        $data = [];

        // フォロー数
        $data['follow_num'] = 0;

        // フォロワー数
        $data['follower_num'] = 0;

        // 自分のサイト
        $data['sites'] = $this->getSites($userId);

        // お気に入りゲーム
        $data['favoriteGames'] = $this->getFavoriteGames($userId);

        // お気に入りサイト
        $data['favoriteSites'] = $this->getFavoriteSites($userId);

        // レビュー
        $data['reviews'] = $this->getReviews($userId);

        // いいねしたレビュー
        $data['goodReviews'] = $this->getGoodReviews($userId);

        // ゲームマスター
        $data['games'] = $this->getGameMaster($data);
        // ユーザーマスター
        $data['users'] = $this->getUserMaster($data);

        return $data;
    }

    /**
     * サイトを取得
     *
     * @param $userId
     * @return mixed
     */
    private function getSites($userId)
    {
        return Site::where('user_id', $userId)
            ->orderBy('id')
            ->take(3)
            ->get();
    }

    /**
     * お気に入りゲームを取得
     *
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    private function getFavoriteGames($userId)
    {
        return UserFavoriteGame::where('user_id', $userId)
            ->orderBy('id')
            ->take(5)
            ->get();
    }

    /**
     * レビューをshつ億
     *
     * @param $userId
     * @return mixed
     */
    private function getReviews($userId)
    {
        return Review::where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->take(3)
            ->get();
    }

    /**
     * いいねしたレビュー
     *
     * @param $userId
     * @return array
     */
    private function getGoodReviews($userId)
    {
        $result = [
            'order' => [],
            'reviews' => []
        ];

        $result['order'] = ReviewGoodHistory::where('user_id', $userId)
            ->orderBy('good_date', 'DESC')
            ->take(3)
            ->get();

        if (empty($result['order'])) {
            return $result;
        }

        $reviews = Review::whereIn('id', array_pluck($result['order']->toArray(), 'review_id'))->get();
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
    private function getFavoriteSites($userId)
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

        $sites = Site::whereIn('id', $result['order'])->get();

        foreach ($sites as $s) {
            $result['sites'][$s->id] = $s;
        }

        return $result;
    }

    /**
     * 必要なゲームマスターを取得
     *
     * @param array $data
     * @return array
     */
    private function getGameMaster(array $data)
    {
        $gameIds = array_merge(
            array_pluck($data['favoriteGames']->toArray(), 'game_id'),
            array_pluck($data['reviews']->toArray(), 'game_id'),
            array_pluck(array_pluck($data['goodReviews']['order']->toArray(), 'review_id'), 'game_id')
        );

        return Game::getNameHash($gameIds);
    }

    /**
     * 必要なユーザーマスターを取得
     *
     * @param array $data
     * @return
     */
    private function getUserMaster(array $data)
    {
        $userIds = array_merge(
            array_pluck($data['favoriteSites']['sites'], 'user_id'),
            array_pluck($data['reviews']->toArray(), 'user_id'),
            array_pluck($data['goodReviews']['reviews'], 'user_id')
        );


        return User::getNameHash($userIds);
    }
}