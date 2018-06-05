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

        if (env('APP_ENV') == 'staging') {
            self::$db = $client->hgs3_stg;
        } else {
            self::$db = $client->hgs3;
        }
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

        $dbName = env('APP_ENV') == 'staging' ? 'hgs3_stg' : 'hgs3';

        echo 'drop hgs3'.PHP_EOL;
        $client->dropDatabase($dbName);
        echo 'create hgs3'.PHP_EOL;
        $db = $client->selectDatabase($dbName);

        echo 'create collections'.PHP_EOL;
        $db->createCollection('favorite_soft_timeline');
        $db->createCollection('favorite_site_timeline');
        $db->createCollection('follow_user_timeline');
        $db->createCollection('to_me_timeline');
        $db->createCollection('user_action_timeline');
        $db->createCollection('site_footprint');
        $db->createCollection('site_timeline');
        $db->createCollection('new_information');

        echo 'create indexes'.PHP_EOL;
        $db->favorite_soft_timeline->createIndex([
            'game_id' => 1,
            'time'    => -1
        ]);
        $db->favorite_site_timeline->createIndex([
            'site_id' => 1,
            'time'    => -1,
        ]);
        $db->follow_user_timeline->createIndex([
            'user_id' => 1,
            'time'    => -1,
        ]);
        $db->to_me_timeline->createIndex([
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
        $db->site_timeline->createIndex([
            'time' => -1
        ]);
        $db->new_information->createIndex([
            'time' => -1
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