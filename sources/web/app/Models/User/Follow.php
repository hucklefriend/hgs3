<?php
/**
 * フォローモデル
 */


namespace Hgs3\Models\User;

use Hgs3\Models\User;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Timeline;

class Follow
{
    /**
     * $userIdが$followUserIdをフォローしているか
     *
     * @param int $userId
     * @param int $followUserId
     * @return bool
     */
    public static function isFollow($userId, $followUserId)
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
     * @return bool
     */
    public static function isFollower($userId, $followerUserId)
    {
        return self::isFollow($followerUserId, $userId);
    }

    /**
     * フォローしているユーザーの一覧を取得
     *
     * @param $userId
     * @param int $category
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getFollow($userId, $category = 0)
    {
        return Orm\UserFollow::where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->paginate(30);
    }

    /**
     * フォローされているユーザーの一覧を取得
     *
     * @param $userId
     * @param int $category
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getFollower($userId, $category = 0)
    {
        return Orm\UserFollow::where('follow_user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->paginate(30);
    }

    /**
     * 追加
     *
     * @param User $user
     * @param User $followUser
     * @param int $followCategory
     */
    public static function add(User $user, User $followUser, $followCategory = 0)
    {
        if ($user->id == $followUser->id) {
            return ;
        }

        $sql =<<< SQL
INSERT IGNORE INTO user_follows
(user_id, category, follow_user_id, created_at, updated_at)
VALUES (?, ?, ?, NOW(), NOW())
SQL;
        DB::insert($sql, [$user->id, $followCategory, $followUser->id]);


        Timeline\ToMe::addFollowerText($followUser, $user);
    }

    /**
     * 削除
     *
     * @param int $userId
     * @param int $followUserId
     * @return int
     */
    public static function remove($userId, $followUserId)
    {
        return DB::table('user_follows')
            ->where('user_id', $userId)
            ->where('follow_user_id', $followUserId)
            ->delete();
    }

    /**
     * フォロー数を取得
     *
     * @param int $userId
     * @return int
     */
    public static function getFollowNum($userId)
    {
        return DB::table('user_follows')
            ->where('user_id', $userId)
            ->count();
    }

    /**
     * フォロワー数を取得
     *
     * @param int $userId
     * @return int
     */
    public static function getFollowerNum($userId)
    {
        return DB::table('user_follows')
            ->where('follow_user_id', $userId)
            ->count();
    }
}