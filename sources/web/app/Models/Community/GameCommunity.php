<?php
/**
 * ゲームコミュニティモデル
 */

namespace Hgs3\Models\Community;

use Hgs3\Models\Orm\GameSoft;
use Hgs3\Models\Orm\GameCommunityMember;
use Hgs3\Models\Orm\GameCommunityTopic;
use Hgs3\Models\Orm\GameCommunityTopicResponse;
use Hgs3\Models\Orm;
use Hgs3\User;
use Hgs3\Models\Timeline;
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
     * @param int $softId
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public function getOlderMembers($softId)
    {
        return GameCommunityMember::where('soft_id', $softId)
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
     * @param GameSoft $gameSoft
     * @param User $user
     * @return bool
     */
    public function join(GameSoft $gameSoft, User $user)
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
            DB::insert($sql, [$gameSoft->id, $user->id]);

            $sql =<<< SQL
UPDATE game_communities
SET user_num = user_num + 1
WHERE id = ?
SQL;
            if (DB::update($sql, [$gameSoft->id]) == 0) {
                DB::table('game_communities')
                    ->insert([
                        'id'       => $gameSoft->id,
                        'user_num' => 1
                    ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        // タイムライン
        Timeline\FollowUser::addJoinGameCommunityText($user->id, $user->name, $gameSoft->id, $gameSoft->name);

        return true;
    }

    /**
     * 脱退
     *
     * @param GameSoft $game
     * @param User $user
     * @return bool
     */
    public function leave(GameSoft $game, User $user)
    {
        DB::beginTransaction();

        try {
            $sql =<<< SQL
DELETE FROM game_community_members
WHERE game_id = ? AND user_id = ?
SQL;
            DB::insert($sql, [$game->id, $user->id]);

            $sql =<<< SQL
UPDATE game_communities
SET user_num = user_num - 1
WHERE id = ?
SQL;
            DB::update($sql, [$game->id]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        // タイムライン
        Timeline\FollowUser::addLeaveGameCommunityText($user->id, $user->name, $game->id, $game->name);

        return true;
    }

    /**
     * 参加しているか？
     *
     * @param int $gameId
     * @param int $userId
     * @return bool
     */
    public function isMember($gameId, $userId)
    {
        return DB::table('game_community_members')
            ->where('game_id', $gameId)
            ->where('user_id', $userId)
            ->count() > 0;
    }

    /**
     * トピックを取得
     *
     * @param int $gameId
     * @return array
     */
    public function getTopics($gameId)
    {
        $pager = DB::table('game_community_topics')
            ->where('game_id', $gameId)
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
     * @param int $gameId
     * @return \Illuminate\Support\Collection
     */
    public function getLatestTopics($gameId)
    {
        return DB::table('game_community_topics')
            ->where('game_id', $gameId)
            ->orderBy('id', 'DESC')
            ->take(5)
            ->get();
    }

    /**
     * トピックの詳細を取得
     *
     * @param GameCommunityTopic $gct
     * @return array
     */
    public function getTopicDetail(GameCommunityTopic $gct)
    {
        $pager = DB::table('game_community_topic_responses')
            ->where('game_community_topic_id', $gct->id)
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
     * @param Orm\GameSoft $game
     * @param User $user
     * @param int $title
     * @param string $comment
     */
    public function writeTopic(Orm\GameSoft $game, User $user, $title, $comment)
    {
        $now = new \DateTime();

        $topicId = GameCommunityTopic::insertGetId([
            'game_id'       => $game->id,
            'user_id'       => $user->id,
            'title'         => $title,
            'comment'       => $comment,
            'wrote_date'    => $now,
            'response_date' => $now,
            'response_num'  => 0
        ]);

        // タイムライン
        Timeline\GameCommunity::addNewTopicText($game->id, $game->name, $topicId);
    }

    /**
     * レスを投稿
     *
     * @param Orm\GameCommunityTopic $gameCommunityTopic
     * @param User $user
     * @param $comment
     */
    public function writeResponse(Orm\GameCommunityTopic $gameCommunityTopic, User $user, $comment)
    {
        $now = new \DateTime();

        DB::beginTransaction();

        try {
            GameCommunityTopicResponse::insert([
                'game_community_topic_id' => $gameCommunityTopic->id,
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
            DB::update($updSql, [$gameCommunityTopic->id]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        // タイムライン
        Timeline\ToMe::addGameCommunityTopicResponseText(
            $gameCommunityTopic->user_id, $gameCommunityTopic->game_id, null, $gameCommunityTopic->id
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
     * @param GameCommunityTopicResponse $gctr
     * @return bool
     */
    public function eraseTopicResponse(GameCommunityTopicResponse $gctr)
    {
        DB::beginTransaction();

        try {
            $updSql =<<< SQL
UPDATE game_community_topics
SET response_num = response_num - 1
WHERE id = ?
SQL;
            DB::update($updSql, [$gctr->topic_id]);

            $gctr->delete();

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
     * @param GameSoft $game
     * @return \Illuminate\Support\Collection
     */
    public function getMembers(GameSoft $game)
    {
        return DB::table('game_community_members')
            ->where('game_id', $game->id)
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
    public function getNewerJoinCommunity($userId)
    {
        return DB::table('game_community_members')
            ->where('user_id', $userId)
            ->orderBy('join_date', 'DESC')
            ->take(5)
            ->get()
            ->pluck('game_id')
            ->toArray();
    }

    /**
     * 一覧用データを取得
     *
     * @param $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getJoinCommunity($userId)
    {
        return DB::table('game_community_members')
            ->where('user_id', $userId)
            ->orderBy('join_date', 'DESC')
            ->paginate(30);
    }
}
