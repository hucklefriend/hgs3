<?php

namespace Hgs3\Models\Community;

use Hgs3\Models\Orm\UserCommunityMember;
use Hgs3\Models\Orm\UserCommunityTopic;
use Hgs3\Models\Orm\UserCommunityTopicResponse;
use Hgs3\User;
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

    public function add($userCommunityId, $userId)
    {
        $sql =<<< SQL
INSERT IGNORE INTO user_community_members (
  user_community_id, user_id, join_date, created_at, updated_at
) VALUES (
  ?, ?, NOW(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
)
SQL;

        DB::insert($sql, [$userCommunityId, $userId]);
    }

    /**
     * ユーザー数を更新
     *
     * @param $userCommunityId
     */
    public static function updateUserNum()
    {
        $sql =<<< SQL
UPDATE user_communities AS uc,
  (SELECT user_community_id, COUNT(user_id) user_num FROM user_community_members GROUP BY user_community_id) AS ucm
SET uc.user_num = ucm.user_num
WHERE uc.id = ucm.user_community_id
SQL;

        DB::update($sql);
    }

    /**
     * 参加
     *
     * @param $userCommunityId
     * @param $userId
     * @return bool
     */
    public function join($userCommunityId, $userId)
    {
        DB::beginTransaction();

        try {
            $sql =<<< SQL
INSERT IGNORE INTO user_community_members (
  user_community_id, user_id, join_date, created_at, updated_at
) VALUES (
  ?, ?, NOW(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
)
SQL;
            DB::insert($sql, [$userCommunityId, $userId]);

            $sql =<<< SQL
UPDATE user_communities
SET user_num = user_num + 1
WHERE id = ?
SQL;
            DB::update($sql, [$userCommunityId]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
    }

    /**
     * 脱退
     *
     * @param $userCommunityId
     * @param $userId
     * @return bool
     */
    public function secession($userCommunityId, $userId)
    {
        DB::beginTransaction();

        try {
            $sql =<<< SQL
DELETE FROM user_community_members
WHERE user_community_id = ? AND user_id = ?
SQL;
            DB::insert($sql, [$userCommunityId, $userId]);

            $sql =<<< SQL
UPDATE user_communities
SET user_num = user_num - 1
WHERE id = ?
SQL;
            DB::update($sql, [$userCommunityId]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
    }

    /**
     * 参加しているか？
     *
     * @param $userCommunityId
     * @param $userId
     * @return bool
     */
    public function isMember($userCommunityId, $userId)
    {
        return DB::table('user_community_members')
            ->where('user_community_id', $userCommunityId)
            ->where('user_id', $userId)
            ->count() > 0;
    }

    /**
     * トピックを取得
     *
     * @param $userCommunityId
     * @return array
     */
    public function getTopics($userCommunityId)
    {
        $pager = DB::table('user_community_topics')
            ->where('user_community_id', $userCommunityId)
            ->orderBy('id', 'DESC')
            ->paginate(30);

        return [
            'pager' => $pager,
            'users' => User::getNameHash(array_pluck($pager->items(), 'user_id'))
        ];
    }

    /**
     * 直近のトピックを取得
     *
     * @param $userCommunityId
     * @return \Illuminate\Support\Collection
     */
    public function getLatestTopics($userCommunityId)
    {
        return DB::table('user_community_topics')
            ->where('user_community_id', $userCommunityId)
            ->orderBy('id', 'DESC')
            ->take(5)
            ->get();
    }

    /**
     * トピックを投稿
     *
     * @param $userCommunityId
     * @param $userId
     * @param $title
     * @param $comment
     */
    public function writeTopic($userCommunityId, $userId, $title, $comment)
    {
        $now = new \DateTime();

        UserCommunityTopic::insert([
            'user_community_id' => $userCommunityId,
            'user_id'           => $userId,
            'title'             => $title,
            'comment'           => $comment,
            'wrote_date'        => $now,
            'response_date'     => $now,
            'response_num'      => 0
        ]);
    }

    /**
     * レスを投稿
     *
     * @param $topicId
     * @param $userId
     * @param $comment
     */
    public function writeResponse($topicId, $userId, $comment)
    {
        $now = new \DateTime();

        DB::beginTransaction();

        try {
            UserCommunityTopicResponse::insert([
                'user_community_topic_id' => $topicId,
                'user_id'                 => $userId,
                'comment'                 => $comment,
                'wrote_date'              => $now
            ]);

            $updSql =<<< SQL
UPDATE user_community_topics
SET response_num = response_num + 1
  , response_date = NOW()
WHERE id = ?
SQL;
            DB::update($updSql, [$topicId]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
    }
}
