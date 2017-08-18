<?php
/**
 * ユーザープレイゲームのテストデータ生成
 */

namespace Hgs3\Models\Test;

class UserPlayedGame
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        $users = User::getIds();
        $userMax = count($users) - 1;

        $games = Game::getIds();

        foreach ($games as $gameId) {
            $num = rand(0, $userMax);

            for ($i = 0; $i < $num; $i++) {
                $orm = new \Hgs3\Models\Orm\UserPlayedGame;

                $orm->user_id = $users[rand(0, $userMax)];
                $orm->game_id = $gameId;
                $orm->comment = str_random(rand(3, 30));
                $orm->save();
            }
        }
    }
}