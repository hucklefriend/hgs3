<?php

namespace Hgs3\Models\User;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\UserFollow;

class Follow
{
    public function get_list($userId, $category)
    {
        return UserFollow::where('user_id', $userId)
            ->where()
            ->orderBy('follow_date', 'desc')
            ->get();
    }

    public function add($userId, $followUserId, $followCategory)
    {
        $sql =<<< SQL
INSERT IGNORE INTO user_follows
(user_id, category, follow_user_id, created_at, updated_at)
VALUES (?, ?, ?, NOW(), NOW())
SQL;
        DB::insert($sql, [$userId, $followCategory, $followUserId]);
    }

    public function remove($userId, $followUserId)
    {
        UserFollow::destroy([$userId, $followUserId]);
    }
}