<?php

namespace Hgs3\Models\Community;

use Hgs3\Models\Orm\UserCommunityMember;
use Hgs3\Models\Orm\UserCommunityTopic;
use Hgs3\Models\Orm\UserCommunityTopicResponse;
use Hgs3\User;
use Illuminate\Support\Facades\DB;

class GameCommunity
{
    /**
     * メンバー数を取得
     *
     * @return array
     */
    public function getMemberNum()
    {
        return DB::table('game_communities')
            ->select(['id', 'user_num'])
            ->get()
            ->pluck('user_num', 'id')
            ->toArray();
    }


    /**
     * 古参メンバーを取得
     *
     * @param int $gameId
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function getOlderMembers($gameId)
    {
        return UserCommunityMember::where('game_community_id', $userCommunityId)
            ->orderBy('join_date')
            ->take(5)
            ->get();
    }

    /**
     * ユーザー数を更新
     *
     * @param $userCommunityId
     */
    public static function updateUserNum()
    {
        $sql =<<< SQL
UPDATE game_communities AS uc,
  (SELECT game_id, COUNT(user_id) user_num FROM game_community_members GROUP BY game_id) AS gcm
SET uc.user_num = ucm.user_num
WHERE uc.id = ucm.user_community_id
SQL;

        DB::update($sql);
    }

    /**
     * 参加
     *
     * @param $gameId
     * @param $userId
     * @return bool
     */
    public function join($gameId, $userId)
    {
        DB::beginTransaction();

        try {
            $sql =<<< SQL
INSERT IGNORE INTO game_community_members (
  game_id, user_id, join_date, created_at, updated_at
) VALUES (
  ?, ?, NOW(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
)
SQL;
            DB::insert($sql, [$gameId, $userId]);

            $sql =<<< SQL
UPDATE game_communities
SET user_num = user_num + 1
WHERE id = ?
SQL;
            if (DB::update($sql, [$gameId]) == 0) {
                DB::table('game_communities')
                    ->insert([
                        'id'       => $gameId,
                        'user_num' => 1
                    ]);
            }

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
     * @param $gameId
     * @param $userId
     * @return bool
     */
    public function secession($gameId, $userId)
    {
        DB::beginTransaction();

        try {
            $sql =<<< SQL
DELETE FROM game_community_members
WHERE game_id = ? AND user_id = ?
SQL;
            DB::insert($sql, [$gameId, $userId]);

            $sql =<<< SQL
UPDATE game_communities
SET user_num = user_num - 1
WHERE id = ?
SQL;
            DB::update($sql, [$gameId]);

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
            return false;
        }

        return true;
    }

    /**
     * レスの消去
     *
     * @param UserCommunityTopicResponse $uctr
     * @return bool
     */
    public function eraseTopicResponse(UserCommunityTopicResponse $uctr)
    {
        DB::beginTransaction();

        try {
            $updSql =<<< SQL
UPDATE user_community_topics
SET response_num = response_num - 1
WHERE id = ?
SQL;
            DB::update($updSql, [$uctr->topic_id]);

            $uctr->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
    }
}
