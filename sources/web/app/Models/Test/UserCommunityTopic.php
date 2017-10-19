<?php
/**
 * ユーザーコミュニティのトピックのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm;

class UserCommunityTopic
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create user community topic test data.'.PHP_EOL;

        $uc = new \Hgs3\Models\Community\UserCommunity();

        $userCommunities = UserCommunity::get();


        Orm\UserCommunity::chunk(100, function ($userCommunities){
            foreach ($userCommunities as $userCommunity) {
                for ($i = 0; $i < 100; $i++) {
                    $uc->writeTopic($userCommunity, 1, 'テスト' . $i, str_random(500));
                }
            }
        });
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