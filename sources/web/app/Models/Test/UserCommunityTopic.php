<?php
/**
 * ユーザーコミュニティのトピックのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;

class UserCommunityTopic
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        $uc = new \Hgs3\Models\Community\UserCommunity();

        $ucIds = UserCommunity::getIds();
        foreach ($ucIds as $ucId) {
            for ($i = 0; $i < 100; $i++) {
                $uc->writeTopic($ucId, 1, 'テスト' . $i, str_random(500));
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