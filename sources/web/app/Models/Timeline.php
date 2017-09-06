<?php
/**
 * タイムラインモデル
 */

namespace Hgs3\Models;

use Hgs3\Constants\TimelineText;

class Timeline
{
    public function add($tltId, $param = [])
    {

    }



    public function addNewGameSoftText($gameId, $gameName)
    {
        $text = TimelineText::getInstance()->getText(TimelineText::TLT_NEW_GAME_SOFT, [
            url2('game/soft').'/'.$gameId, $gameName
        ]);




    }

    public function getUpdateGameSoftText($gameId, $gameName)
    {
        return sprintf($this->text[self::TLT_UPDATE_GAME_SOFT], url2('game/soft').'/'.$gameId, $gameName);
    }


    private function save()
    {
        $client = new \MongoDB\Client("mongodb://localhost:27017");
    }
}