<?php
/**
 * ユーザーお気に入りゲームのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Hgs3\Models\User\FavoriteGame;
use Illuminate\Support\Facades\DB;

class UserFavoriteGame
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create user favorite game test data.'.PHP_EOL;

        $users = User::get();
        $userMax = $users->count() - 1;

        $games = Game::get();

        $fav = new FavoriteGame();

        /*
        DB::table('user_favorite_games')
            ->truncate();
        */
        foreach ($games as $game) {
            $num = rand(0, $userMax);

            for ($i = 0; $i < $num; $i++) {
                $fav->add($users[rand(0, $userMax)], $game);
            }
        }

        unset($users);
        unset($games);
    }
}