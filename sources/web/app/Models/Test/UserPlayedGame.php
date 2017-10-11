<?php
/**
 * ユーザープレイゲームのテストデータ生成
 */

namespace Hgs3\Models\Test;

use Illuminate\Support\Facades\DB;

class UserPlayedGame
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create user played game test data.'.PHP_EOL;

        $users = User::getIds();
        $userMax = count($users) - 1;

        $games = Game::getIds();

        $sql =<<< SQL
INSERT IGNORE INTO user_played_games
(user_id, game_id, comment, created_at, updated_at)
VALUES (?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
SQL;


        foreach ($games as $gameId) {
            $num = rand(0, $userMax);

            for ($i = 0; $i < $num; $i++) {
                DB::insert($sql, [
                    $users[rand(0, $userMax)],
                    $gameId,
                    str_random(rand(3, 30))
                ]);
            }
        }
    }
}