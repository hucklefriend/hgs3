<?php

namespace Hgs3\Models\Community;

use Hgs3\Models\Orm\UserCommunityMember;
use Illuminate\Support\Facades\DB;

class UserCommunity
{
    /**
     * デフォルトで存在するコミュニティを作成
     */
    public static function createDefaultCommunity()
    {
        $uc = new \Hgs3\Models\Orm\UserCommunity([
            'user_id'  => 1,
            'name'     => 'テスト',
            'user_num' => 1,
        ]);

        $uc->save();

    }

    public function getOlderMembers($userCommunityId)
    {
        return UserCommunityMember::where('user_community_id', $userCommunityId)
            ->orderBy('join_date')
            ->take(5)
            ->get();
    }
}