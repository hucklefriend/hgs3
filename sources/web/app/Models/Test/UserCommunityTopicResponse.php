<?php
/**
 * ユーザーコミュニティのトピックのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;

class UserCommunityTopicResponse
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create user community topic response test data.'.PHP_EOL;

        $uc = new \Hgs3\Models\Community\UserCommunity();
        $userIds = User::getIds();
        $userMax = count($userIds) - 1;

        $uctIds = UserCommunityTopic::getIds();
        foreach ($uctIds as $topicId) {
            $n = rand(0, 100);
            for ($i = 0; $i < $n; $i++) {
                $uc->writeResponse($topicId, $userIds[rand(0, $userMax)], str_random(500));
            }
        }
    }

    /**
     * ユーザーIDの配列を取得
     *
     * @return array
     */
    public static function getIds()
    {
        return DB::table('user_community_topics')
            ->select('id')
            ->get()
            ->pluck('id');
    }
}