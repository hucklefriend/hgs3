<?php
/**
 * ORM user_communities
 */

namespace Hgs3\Models\Orm;

use Illuminate\Support\Facades\DB;

class UserCommunity extends \Eloquent
{
    //
    protected $guarded = ['id'];

    /**
     * メンバー一覧を取得
     *
     * @return \Illuminate\Support\Collection
     */
    public function getMembers()
    {
        return DB::table('user_community_members')
            ->where('user_community_id', $this->id)
            ->orderBy('join_date')
            ->get();
    }
}
