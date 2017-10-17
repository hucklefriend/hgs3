<?php
/**
 * MongoDBコレクション
 */

namespace Hgs3\Models\MongoDB;

class Collection
{
    private $db;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $client = new \MongoDB\Client("mongodb://localhost:27017");
        $this->db = $client->hgs3;
    }

    /**
     * ゲームタイムラインのコレクションを取得
     *
     * @return \MongoDB\Collection
     */
    public function getGameTimelineCollection()
    {
        return $this->db->game_timeline;
    }
}