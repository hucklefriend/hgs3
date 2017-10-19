<?php
/**
 * ゲームコミュニティメンバー
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;

class GameCommunityMember
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create game community member test data.' . PHP_EOL;

        $users = User::get();
        $games = Game::get();
        $gameMax = $games->count() - 1;

        $gc = new \Hgs3\Models\Community\GameCommunity();

        foreach ($users as $user) {
            $num = rand(0, 30);

            for ($i = 0; $i < $num; $i++) {
                $gc->join($user, $games[rand(0, $gameMax)]);
            }
        }

        unset($users);
        unset($games);
    }
}