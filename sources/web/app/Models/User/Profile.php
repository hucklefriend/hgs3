<?php
/**
 * プロフィールモデル
 */


namespace Hgs3\Models\User;
use Illuminate\Support\Facades\DB;

class Profile
{
    /**
     * データ取得
     *
     * @param $userId
     */
    public function get($userId)
    {
        $data = [];

        // フォロー数
        $data['follow_num'] = 0;

        // フォロワー数
        $data['follower_num'] = 0;
    }
}