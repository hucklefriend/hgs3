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
        $gc = new \Hgs3\Models\Community\GameCommunity();
        $userIds = User::getIds();
        $userMax = count($userIds) - 1;

        $uctIds = GameCommunityTopic::getIds();
        foreach ($uctIds as $topicId) {
            $n = rand(0, 100);
            for ($i = 0; $i < $n; $i++) {
                $gc->writeResponse($topicId, $userIds[rand(0, $userMax)], str_random(500));
            }
        }
    }
}