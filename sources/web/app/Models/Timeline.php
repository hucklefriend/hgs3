<?php
/**
 * タイムラインモデル
 */

namespace Hgs3\Models;

use Hgs3\Constants\TimelineText;
use Hgs3\Constants\TimelineType;
use Hgs3\Models\Orm\Game;

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
        if ($gameName === null) {
            $gameName = $this->getGameName($gameId);
            if ($gameName === false) {
                return;
            }
        }

        $text = sprintf('「<a href="%s">%s</a>」が追加されました。',
            url2('game/soft').'/'.$gameId,
            $gameName
        );

        $this->insert(TimelineType::NEW_GAME_SOFT, $text, ['game_id' => $gameId]);
    }

    /**
     * ゲームソフト更新
     *
     * @param int $gameId
     * @param string $gameName
     */
    public function addUpdateGameSoftText($gameId, $gameName)
    {
        if ($gameName === null) {
            $gameName = $this->getGameName($gameId);
            if ($gameName === false) {
                return;
            }
        }

        $text = sprintf('「<a href="%s">%s</a>」の情報が更新されました。',
            url2('game/soft').'/'.$gameId,
            $gameName
        );

        $this->insert(TimelineType::UPDATE_GAME_SOFT, $text, ['game_id' => $gameId]);
    }

    /**
     * MongoDBのコレクションを取得
     *
     * @return mixed
     */
    public function getMongoCollection()
    {
        $client = new \MongoDB\Client("mongodb://localhost:27017");
        return $client->hgs3->timeline;
    }


    /**
     * データ登録
     *
     * @param int $type
     * @param string $text
     * @param array $option
     */
    private function insert($type, $text, $option = [])
    {
        $data = [
            'type' => $type,
            'text' => $text,
            'time' => time()
        ];

        $collection = $this->getMongoCollection();
        $collection->insertOne($data + $option);
    }

    /**
     * ゲーム名を取得
     *
     * @param $gameId
     * @return bool|mixed
     */
    private function getGameName($gameId)
    {
        $game = Game::find($gameId);
        if ($game !== null) {
            return $game->name;
        }

        return false;
    }
}