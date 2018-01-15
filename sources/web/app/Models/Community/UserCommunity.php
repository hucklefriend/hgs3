<?php

namespace Hgs3\Models\Community;

use Hgs3\Models\Orm;
use Hgs3\Models\User;
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
        $uc = new Orm\UserCommunity([
            'user_id'  => 1,
            'name'     => 'テスト',
            'user_num' => 1,
        ]);

        $uc->save();

    }

    /**
     * 参加の古い順にユーザーを太く
     *
     * @param int $userCommunityId
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function getOlderMembers($userCommunityId)
    {
        return Orm\UserCommunityMember::where('user_community_id', $userCommunityId)
            ->orderBy('join_at')
            ->take(5)
            ->get();
    }

    /**
     * メンバーを追加
     *
     * @param $userCommunityId
     * @param $userId
     */
    public function add($userCommunityId, $userId)
    {
        $sql =<<< SQL
INSERT IGNORE INTO user_community_members (
  user_community_id, user_id, join_at, created_at, updated_at
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
  user_community_id, user_id, join_at, created_at, updated_at
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
        Timeline\FollowUser::addJoinUserCommunityText($user, $userCommunity);
        Timeline\UserCommunity::addJoinUserText();

        return true;
    }

    /**
     * 脱退
     *
     * @param Orm\UserCommunity $userCommunity
     * @param User $user
     * @return bool
     */
    public function leave(Orm\UserCommunity $userCommunity, User $user)
    {
        DB::beginTransaction();

        try {
            $sql =<<< SQL
DELETE FROM user_community_members
WHERE user_community_id = ? AND user_id = ?
SQL;
            DB::insert($sql, [$userCommunity->id, $user->id]);

            $sql =<<< SQL
UPDATE user_communities
SET user_num = user_num - 1
WHERE id = ?
SQL;
            DB::update($sql, [$userCommunity->id]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        // タイムライン
        Timeline\FollowUser::addLeaveUserCommunityText($user, $userCommunity);

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
     * @param int $userCommunityId
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
     * @param Orm\UserCommunityTopic $uct
     * @return array
     */
    public function getTopicDetail(Orm\UserCommunityTopic $uct)
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
     * @param int $userId
     * @param string $title
     * @param string $comment
     */
    public function writeTopic(Orm\UserCommunity $userCommunity, $userId, $title, $comment)
    {
        $now = new \DateTime();

        $topicId = Orm\UserCommunityTopic::insertGetId([
            'user_community_id' => $userCommunity->id,
            'user_id'           => $userId,
            'title'             => $title,
            'comment'           => $comment,
            'write_at'          => $now,
            'response_at'       => $now,
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
            Orm\UserCommunityTopicResponse::insert([
                'user_community_topic_id' => $userCommunityTopic->id,
                'user_id'                 => $user->id,
                'comment'                 => $comment,
                'wrote_at'                => $now
            ]);

            $updSql =<<< SQL
UPDATE user_community_topics
SET response_num = response_num + 1
  , response_at = NOW()
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
        $topicMaster = User::find($topic->user_id);
        if ($topicMaster) {
            Timeline\ToMe::addUserCommunityTopicResponseText($topicMaster, $userCommunity, $topic);
        }

        return true;
    }

    /**
     * トピックの消去
     *
     * @param int $topicId
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
     * @param Orm\UserCommunityTopicResponse $res
     * @return bool
     */
    public function eraseTopicResponse(Orm\UserCommunityTopicResponse $res)
    {
        DB::beginTransaction();

        try {
            $updSql =<<< SQL
UPDATE user_community_topics
SET response_num = response_num - 1
WHERE id = ?
SQL;
            DB::update($updSql, [$res->topic_id]);

            $res->delete();

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
