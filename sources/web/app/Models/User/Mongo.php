<?php
/**
 * MongoDbモデル
 */


namespace Hgs3\Models\User;

use Illuminate\Support\Facades\DB;

class Mongo
{
    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function get()
    {

    }

    public function save($key, $data)
    {

    }

    private static function getUserMongoCollection()
    {
        $client = new \MongoDB\Client("mongodb://localhost:27017");
        return $client->hgs3->user;
    }

    public function saveFromMySQL($userId)
    {
        $data = [];

        // お気に入りゲーム
        $data['favorite_game'] = $this->getFavoriteGame();

        // フォロー
        $data['favorite_site'] = $this->getFavoriteSite();

        // フォロー
        $data['follow'] = $this->getFollow();

    }

    /**
     * お気に入りゲームを取得
     *
     * @param $userId
     * @return array
     */
    public function getFavoriteGame()
    {
        return DB::table('user_favorite_games')
            ->select('game_id')
            ->where('user_id', $this->userId)
            ->get('game_id')
            ->pluck('game_id')
            ->toArray();
    }

    public function getFavoriteSite()
    {
        return DB::table('user_favorite_sites')
            ->select('site_id')
            ->where('user_id', $this->userId)
            ->get('site_id')
            ->pluck('site_id')
            ->toArray();
    }

    public function getFollow()
    {
        return DB::table('user_follows')
            ->select('follow_user_id')
            ->where('user_id', $this->userId)
            ->get('follow_user_id')
            ->pluck('follow_user_id')
            ->toArray();
    }
}