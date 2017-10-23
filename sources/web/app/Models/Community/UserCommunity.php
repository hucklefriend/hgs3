<?php

namespace Hgs3\Models\Community;

use Hgs3\Models\Orm;
use Hgs3\Models\Orm\UserCommunityMember;
use Hgs3\Models\Orm\UserCommunityTopic;
use Hgs3\Models\Orm\UserCommunityTopicResponse;
use Hgs3\User;
use Hgs3\Models\Timeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
     * @param Orm\UserCommunity $userCommunity
     * @param User $user
     * @return bool
     */
    public function join(Orm\UserCommunity $userCommunity, User $user)
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
            DB::insert($sql, [$userCommunity->id, $user->id]);

            $sql =<<< SQL
UPDATE user_communities
SET user_num = user_num + 1
WHERE id = ?
SQL;
            DB::update($sql, [$userCommunity->id]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        // タイムライン
        Timeline\FollowUser::addJoinUserCommunityText($user->id, $user->name, $userCommunity->id, $userCommunity->name);

        return true;
    }

    /**
     * 脱退
     *
     * @param $userCommunityId
     * @param $userId
     * @return bool
     */
    public function leave($userCommunityId, $userId)
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

        Timeline\FollowUser::addLeaveUserCommunityText($user->id, $user->name, $userCommunity->id, $userCommunity->name);

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
     * トピックの詳細を取得
     *
     * @param UserCommunityTopic $uct
     * @return array
     */
    public function getTopicDetail(UserCommunityTopic $uct)
    {
        $pager = DB::table('user_community_topic_responses')
            ->where('user_community_topic_id', $uct->id)
            ->orderBy('id', 'DESC')
            ->paginate(30);

        return [
            'pager' => $pager,
            'users' => User::getNameHash(array_pluck($pager->items(), 'user_id'))
        ];
    }

    /**
     * トピックを投稿
     *
     * @param Orm\UserCommunity $userCommunity
     * @param $userId
     * @param $title
     * @param $comment
     */
    public function writeTopic(Orm\UserCommunity $userCommunity, $userId, $title, $comment)
    {
        $now = new \DateTime();

        $topicId = UserCommunityTopic::insertGetId([
            'user_community_id' => $userCommunity->id,
            'user_id'           => $userId,
            'title'             => $title,
            'comment'           => $comment,
            'wrote_date'        => $now,
            'response_date'     => $now,
            'response_num'      => 0
        ]);

        Timeline\UserCommunity::addNewTopicText($userCommunity->id, $userCommunity->name, $topicId);
    }

    /**
     * レスを投稿
     *
     * @param Orm\UserCommunity $userCommunity
     * @param Orm\UserCommunityTopic $userCommunityTopic
     * @param User $user
     * @param string $comment
     * @return bool
     */
    public function writeResponse(Orm\UserCommunity $userCommunity, Orm\UserCommunityTopic $userCommunityTopic, User $user, $comment)
    {
        $now = new \DateTime();

        DB::beginTransaction();

        try {
            UserCommunityTopicResponse::insert([
                'user_community_topic_id' => $userCommunityTopic->id,
                'user_id'                 => $user->id,
                'comment'                 => $comment,
                'wrote_date'              => $now
            ]);

            $updSql =<<< SQL
UPDATE user_community_topics
SET response_num = response_num + 1
  , response_date = NOW()
WHERE id = ?
SQL;
            DB::update($updSql, [$userCommunityTopic->id]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        // タイムライン
        Timeline\ToMe::addUserCommunityTopicResponseText(
            $userCommunityTopic->user_id,
            $userCommunity->id,
            $userCommunity->name,
            $userCommunityTopic->id
        );


        return true;
    }

    /**
     * トピックの消去
     *
     * @param $topicId
     * @return bool
     */
    public function eraseTopic($topicId)
    {
        DB::beginTransaction();

        try {
            DB::table('user_community_topics')
                ->where('id', $topicId)
                ->delete();

            DB::table('user_community_topic_responses')
                ->where('user_community_topic_id', $topicId)
                ->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return true;
    }

    /**
     * レスの消去
     *
     * @param UserCommunityTopicResponse $userCommunityTopicResponse
     * @return bool
     */
    public function eraseTopicResponse(UserCommunityTopicResponse $userCommunityTopicResponse)
    {
        DB::beginTransaction();

        try {
            $updSql =<<< SQL
UPDATE user_community_topics
SET response_num = response_num - 1
WHERE id = ?
SQL;
            DB::update($updSql, [$userCommunityTopicResponse->topic_id]);

            $userCommunityTopicResponse->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return true;
    }
}
