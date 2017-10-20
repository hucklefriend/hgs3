<?php
/**
 * MongoDBコレクション
 */

namespace Hgs3\Models\MongoDB;

class Collection
{
    /**
     * @var \MongoDB\Database
     */
    private static $db = null;

    private static $instance = null;

    /**
     * コンストラクタ
     */
    private function __construct()
    {
        $client = new \MongoDB\Client("mongodb://localhost:27017");

        self::$db = $client->hgs3;
    }

    /**
     * インスタンスを取得
     *
     * @return Collection
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * コレクション作成
     */
    public static function create()
    {
        $client = new \MongoDB\Client("mongodb://localhost:27017");

        echo 'drop hgs3'.PHP_EOL;
        $client->dropDatabase('hgs3');
        echo 'create hgs3'.PHP_EOL;
        $db = $client->selectDatabase('hgs3');

        echo 'create collections'.PHP_EOL;
        $db->createCollection('game_timeline');
        $db->createCollection('site_timeline');
        $db->createCollection('follow_user_timeline');
        $db->createCollection('game_community_timeline');
        $db->createCollection('user_community_timeline');
        $db->createCollection('myself_timeline');
        $db->createCollection('user_action_timeline');
        $db->createCollection('site_footprint');

        echo 'create indexes'.PHP_EOL;
        $db->game_timeline->createIndex([
            'game_id' => 1,
            'time'    => -1
        ]);
        $db->site_timeline->createIndex([
            'site_id' => 1,
            'time'    => -1,
        ]);
        $db->follow_user_timeline->createIndex([
            'user_id' => 1,
            'time'    => -1,
        ]);
        $db->game_community_timeline->createIndex([
            'game_id' => 1,
            'time'    => -1,
        ]);
        $db->user_community_timeline->createIndex([
            'user_community_id' => 1,
            'time'              => -1,
        ]);
        $db->myself_timeline->createIndex([
            'user_id' => 1,
            'time'    => -1,
        ]);
        $db->user_action_timeline->createIndex([
            'user_id' => 1,
            'time'    => -1,
        ]);
        $db->site_footprint->createIndex([
            'user_id' => 1,
            'time'    => -1,
        ]);
        $db->site_footprint->createIndex([
            'site_id' => 1,
            'time'    => -1,
        ]);
    }

    /**
     * データベースを取得
     *
     * @return \MongoDB\Database
     */
    public function getDatabase()
    {
        return self::$db;
    }
}