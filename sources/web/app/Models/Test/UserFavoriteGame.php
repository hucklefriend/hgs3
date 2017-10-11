<?php
/**
 * ユーザーお気に入りゲームのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Hgs3\Models\User\FavoriteGame;

class UserFavoriteGame
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create user favorite game test data.'.PHP_EOL;

        $users = User::getIds();
        $userMax = count($users) - 1;

        $games = Game::getIds();

        $fav = new FavoriteGame();

        foreach ($games as $gameId) {
            $num = rand(0, $userMax);

            for ($i = 0; $i < $num; $i++) {
                $fav->add($users[rand(0, $userMax)], $gameId);
            }
        }
    }
}