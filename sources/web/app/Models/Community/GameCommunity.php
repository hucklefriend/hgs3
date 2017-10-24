<?php
/**
 * ゲームコミュニティモデル
 */

namespace Hgs3\Models\Community;

use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Hgs3\Models\Timeline;
use Illuminate\Support\Facades\DB;

class GameCommunity
{
    /**
     * メンバー数を取得
     *
     * @return array
     */
    public static function getMemberNum()
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
     * @param int $softId
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public static function getOlderMembers($softId)
    {
        return Orm\GameCommunityMember::where('soft_id', $softId)
            ->orderBy('join_date')
            ->take(5)
            ->get();
    }

    /**
     * ユーザー数を更新
     */
    public static function updateUserNum()
    {
        $sql =<<< SQL
UPDATE game_communities AS uc,
  (SELECT soft_id, COUNT(user_id) user_num FROM game_community_members GROUP BY soft_id) AS gcm
SET uc.user_num = ucm.user_num
WHERE uc.id = ucm.user_community_id
SQL;

        DB::update($sql);
    }

    /**
     * 参加
     *
     * @param Orm\GameSoft $soft
     * @param User $user
     * @return bool
     */
    public static function join(Orm\GameSoft $soft, User $user)
    {
        DB::beginTransaction();

        try {
            $sql =<<< SQL
INSERT IGNORE INTO game_community_members (
  soft_id, user_id, join_date, created_at, updated_at
) VALUES (
  ?, ?, NOW(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
)
SQL;
            DB::insert($sql, [$soft->id, $user->id]);

            $sql =<<< SQL
UPDATE game_communities
SET user_num = user_num + 1
WHERE id = ?
SQL;
            if (DB::update($sql, [$soft->id]) == 0) {
                DB::table('game_communities')
                    ->insert([
                        'id'       => $soft->id,
                        'user_num' => 1
                    ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        // タイムライン
        Timeline\FollowUser::addJoinGameCommunityText($user, $soft);

        return true;
    }

    /**
     * 脱退
     *
     * @param Orm\GameSoft $soft
     * @param User $user
     * @return bool
     */
    public static function leave(Orm\GameSoft $soft, User $user)
    {
        DB::beginTransaction();

        try {
            $sql =<<< SQL
DELETE FROM game_community_members
WHERE game_id = ? AND user_id = ?
SQL;
            DB::insert($sql, [$soft->id, $user->id]);

            $sql =<<< SQL
UPDATE game_communities
SET user_num = user_num - 1
WHERE id = ?
SQL;
            DB::update($sql, [$soft->id]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        // タイムライン
        Timeline\FollowUser::addLeaveGameCommunityText($user, $soft);

        return true;
    }

    /**
     * 参加しているか？
     *
     * @param int $softId
     * @param int $userId
     * @return bool
     */
    public static function isMember($softId, $userId)
    {
        return DB::table('game_community_members')
            ->where('soft_id', $softId)
            ->where('user_id', $userId)
            ->count() > 0;
    }

    /**
     * トピックを取得
     *
     * @param int $softId
     * @return array
     */
    public static function getTopics($softId)
    {
        $pager = DB::table('game_community_topics')
            ->where('soft_id', $softId)
            ->orderBy('id', 'DESC')
            ->paginate(20);

        return [
            'pager' => $pager,
            'users' => User::getNameHash(array_pluck($pager->items(), 'user_id'))
        ];
    }

    /**
     * 直近のトピックを取得
     *
     * @param int $softId
     * @return \Illuminate\Support\Collection
     */
    public static function getLatestTopics($softId)
    {
        return DB::table('game_community_topics')
            ->where('soft_id', $softId)
            ->orderBy('id', 'DESC')
            ->take(5)
            ->get();
    }

    /**
     * トピックの詳細を取得
     *
     * @param Orm\GameCommunityTopic $topic
     * @return array
     */
    public static function getTopicDetail(Orm\GameCommunityTopic $topic)
    {
        $pager = DB::table('game_community_topic_responses')
            ->where('game_community_topic_id', $topic->id)
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
     * @param Orm\GameSoft $soft
     * @param User $user
     * @param int $title
     * @param string $comment
     */
    public static function writeTopic(Orm\GameSoft $soft, User $user, $title, $comment)
    {
        $now = new \DateTime();

        $topic = new Orm\GameCommunityTopic([
            'soft_id'       => $soft->id,
            'user_id'       => $user->id,
            'title'         => $title,
            'comment'       => $comment,
            'wrote_date'    => $now,
            'response_date' => $now,
            'response_num'  => 0
        ]);

        $topic->save();

        // タイムライン
        Timeline\GameCommunity::addNewTopicText($soft, $topic);
    }

    /**
     * レスを投稿
     *
     * @param Orm\GameSoft $soft
     * @param Orm\GameCommunityTopic $topic
     * @param User $user
     * @param $comment
     */
    public static function writeResponse(Orm\GameSoft $soft, Orm\GameCommunityTopic $topic, User $user, $comment)
    {
        $now = new \DateTime();

        DB::beginTransaction();

        try {
            Orm\GameCommunityTopicResponse::insert([
                'game_community_topic_id' => $topic->id,
                'user_id'                 => $user->id,
                'comment'                 => $comment,
                'wrote_date'              => $now
            ]);

            $updSql =<<< SQL
UPDATE game_community_topics
SET response_num = response_num + 1
  , response_date = NOW()
WHERE id = ?
SQL;
            DB::update($updSql, [$topic->id]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        // タイムライン
        Timeline\ToMe::addGameCommunityTopicResponseText($user, $soft, $topic);

        return true;
    }

    /**
     * トピックの消去
     *
     * @param $topicId
     * @return bool
     */
    public static function eraseTopic($topicId)
    {
        DB::beginTransaction();

        try {
            DB::table('game_community_topics')
                ->where('id', $topicId)
                ->delete();

            DB::table('game_community_topic_responses')
                ->where('game_community_topic_id', $topicId)
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
     * @param Orm\GameCommunityTopicResponse $res
     * @return bool
     */
    public function eraseTopicResponse(Orm\GameCommunityTopicResponse $res)
    {
        DB::beginTransaction();

        try {
            $updSql =<<< SQL
UPDATE game_community_topics
SET response_num = response_num - 1
WHERE id = ?
SQL;
            DB::update($updSql, [$res->topic_id]);

            $res->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
    }

    /**
     * メンバー一覧を取得
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Support\Collection
     */
    public static function getMembers(Orm\GameSoft $soft)
    {
        return DB::table('game_community_members')
            ->where('soft_id', $soft->id)
            ->orderBy('join_date')
            ->get()
            ->pluck('user_id')
            ->toArray();
    }

    /**
     * 直近に参加したコミュニティを取得
     *
     * @param $userId
     * @return array
     */
    public static function getNewerJoinCommunity($userId)
    {
        return DB::table('game_community_members')
            ->where('user_id', $userId)
            ->orderBy('join_date', 'DESC')
            ->take(5)
            ->get()
            ->pluck('soft_id')
            ->toArray();
    }

    /**
     * 一覧用データを取得
     *
     * @param $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getJoinCommunity($userId)
    {
        return DB::table('game_community_members')
            ->where('user_id', $userId)
            ->orderBy('join_date', 'DESC')
            ->paginate(30);
    }
}
