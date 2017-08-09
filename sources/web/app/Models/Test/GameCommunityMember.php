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
        $userIds = User::getIds();
        $userMax = count($userIds) - 1;
        $gameIds = Game::getIds();
        $gameMax = count($gameIds) - 1;

        $gc = new \Hgs3\Models\Community\GameCommunity();

        foreach ($userIds as $userId) {
            $num = rand(1, 30);

            for ($i = 0; $i < $num; $i++) {
                $gc->join($userId, $gameIds[rand(0, $gameMax)]);
            }
        }
    }
}