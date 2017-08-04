<?php
/**
 * ユーザーお気に入りサイトのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;

class UserCommunity
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        // とりあえずのところ、管理者しか作れないので数個
        $now = new \DateTime();

        for ($i = 2; $i < 7; $i++) {
            $uc = new \Hgs3\Models\Orm\UserCommunity([
                'user_id'  => 1,
                'name'     => 'テスト' . $i,
                'user_num' => 1
            ]);

            $uc->save();

            DB::table('user_community_members')
                ->insert([
                    'user_community_id' => $uc->id,
                    'user_id'           => 1,
                    'join_date'         => $now->format('Y-m-d H:i:s')
                ]);
        }
    }

    /**
     * ユーザーIDの配列を取得
     *
     * @return array
     */
    public static function getIds()
    {
        return DB::table('user_communities')
            ->select('id')
            ->get()
            ->pluck('id');
    }
}