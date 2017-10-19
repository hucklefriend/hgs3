<?php
/**
 * ゲームコミュニティのトピックのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;

class GameCommunityTopicResponse
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create game community topic response test data.'.PHP_EOL;

        $gc = new \Hgs3\Models\Community\GameCommunity();
        $users = User::get();
        $userMax = $users->count() - 1;

        $gcts = GameCommunityTopic::get();
        foreach ($gcts as $gct) {
            if (rand(0, 100) > 40) {
                continue;
            }

            $n = rand(0, 15);
            for ($i = 0; $i < $n; $i++) {
                $gc->writeResponse($gct, $users[rand(0, $userMax)], str_random(500));
            }
        }

        unset($users);
        unset($gcts);
    }
}