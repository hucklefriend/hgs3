<?php
/**
 * フォローモデル
 */


namespace Hgs3\Models\User;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\UserFollow;

class Follow
{
    /**
     * $userIdが$followUserIdをフォローしているか
     *
     * @param int $userId
     * @param int $followUserId
     */
    public function isFollow($userId, $followUserId)
    {
        return DB::table('user_follows')
            ->where('user_id', $userId)
            ->where('follow_user_id', $followUserId)
            ->count() == 1;
    }

    /**
     * $followerUserIdが$userIdをフォローしているか（$userIdのフォロワーか)
     *
     * @param int $userId
     * @param int $followerUserId
     */
    public function isFollower($userId, $followerUserId)
    {
        return $this->isFollow($followerUserId, $userId);
    }

    /**
     * フォローしているユーザーの一覧を取得
     *
     * @param $userId
     * @param int $category
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFollow($userId, $category = 0)
    {
        return DB::table('user_follows')
            ->where('user_id', $userId)
            ->paginate(30);
    }

    /**
     * フォローされているユーザーの一覧を取得
     *
     * @param $userId
     * @param int $category
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFollower($userId, $category = 0)
    {
        return DB::table('user_follows')
            ->where('follow_user_id', $userId)
            ->paginate(30);
    }

    /**
     * 追加
     *
     * @param $userId
     * @param $followUserId
     * @param $followCategory
     */
    public function add($userId, $followUserId, $followCategory = 0)
    {
        if ($userId == $followUserId) {
            return 0;
        }

        $sql =<<< SQL
INSERT IGNORE INTO user_follows
(user_id, category, follow_user_id, created_at, updated_at)
VALUES (?, ?, ?, NOW(), NOW())
SQL;
        DB::insert($sql, [$userId, $followCategory, $followUserId]);
    }

    /**
     * 削除
     *
     * @param $userId
     * @param $followUserId
     * @return int
     */
    public function remove($userId, $followUserId)
    {
        return DB::table('user_follows')
            ->where('user_id', $userId)
            ->where('follow_user_id', $followUserId)
            ->delete();
    }

    /**
     * フォロー数を取得
     *
     * @param $userId
     * @return int
     */
    public function getFollowNum($userId)
    {
        return DB::table('user_follows')
            ->where('user_id', $userId)
            ->count();
    }

    /**
     * フォロワー数を取得
     *
     * @param $userId
     * @return int
     */
    public function getFollowerNum($userId)
    {
        return DB::table('user_follows')
            ->where('follow_user_id', $userId)
            ->count();
    }
}