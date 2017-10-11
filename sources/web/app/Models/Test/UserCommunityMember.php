<?php
/**
 * ユーザーコミュニティメンバー
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;

class UserCommunityMember
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create user community member test data.'.PHP_EOL;

        $userIds = User::getIds();
        $userMax = count($userIds) - 1;
        $ucIds = UserCommunity::getIds();

        $uc = new \Hgs3\Models\Community\UserCommunity();

        foreach ($ucIds as $ucId) {
            $num = rand(10, $userMax);

            for ($i = 0; $i < $num; $i++) {
                $uc->add($ucId, $userIds[rand(0, $userMax)]);
            }
        }

        // ユーザー数を更新
        \Hgs3\Models\Community\UserCommunity::updateUserNum();
    }
}