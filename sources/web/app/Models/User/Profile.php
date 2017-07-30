<?php
/**
 * プロフィールモデル
 */


namespace Hgs3\Models\User;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\Review;
use Hgs3\Models\Orm\Site;
use Hgs3\Models\Orm\UserFavoriteGame;
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


        $data['games'] = $this->getGameMaster($data);

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
     *
     *
     * @param $userId
     * @return mixed
     */
    private function getReviews($userId)
    {
        return Review::where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->get();
    }

    /**
     * 必要なゲームマスターを取得
     *
     * @param array $data
     * @return array
     */
    private function getGameMaster(array $data)
    {
        $gameIds = [];

        $gameIds = array_merge($gameIds, array_pluck($data['favoriteGames']->toArray(), 'game_id'));

        return Game::getNameHash($gameIds);
    }
}