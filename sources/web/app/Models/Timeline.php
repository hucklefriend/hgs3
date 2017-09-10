<?php
/**
 * タイムラインモデル
 */

namespace Hgs3\Models;

use Hgs3\Constants\TimelineText;

class Timeline
{
    // https://docs.mongodb.com/php-library/master/
    // http://qiita.com/_takwat/items/1d1463d22a1316a2efbe


    /**
     * ゲームソフト追加
     *
     * @param $gameId
     * @param $gameName
     */
    public function addNewGameSoftText($gameId, $gameName)
    {
        $text = sprintf('「<a href="%s">%s</a>」が追加されました。',
            url2('game/soft').'/'.$gameId,
            $gameName
        );



        $this->insert()
    }

    public function getUpdateGameSoftText($gameId, $gameName)
    {
        return sprintf($this->text[self::TLT_UPDATE_GAME_SOFT], url2('game/soft').'/'.$gameId, $gameName);
    }

    /**
     * @return mixed
     */
    private function getMongoCollection()
    {
        $client = new \MongoDB\Client("mongodb://localhost:27017");
        return $client->hgs3->timeline;
    }


    /**
     * データ登録
     *
     * @param $category
     * @param $text
     */
    private function insert($category, $text, $option = [])
    {
        $data = [
            'category' => $category,
            'text'     => $text,
            'time'     => time()
        ];

        $collection = $this->getMongoCollection();
        $collection->insertOne($data + $option);
    }
}