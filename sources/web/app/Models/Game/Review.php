<?php
/**
 * レビューモデル
 */


namespace Hgs3\Models\Game;

use Hgs3\Http\Requests\Game\Review\InputRequest;
use Hgs3\Models\Orm\ReviewDraft;
use Hgs3\Models\Orm\ReviewTotal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Review
{
    /**
     * 新着順レビューを取得
     *
     * @param $gameId
     * @param $num
     */
    public function getNewArrivals($gameId, $num)
    {
        $sql =<<< SQL
SELECT
  reviews.*
  , users.name AS user_name
FROM (
    SELECT id, point, user_id, post_date, title
    FROM reviews
    WHERE game_id = ?
    ORDER BY id DESC
    LIMIT {$num}
  ) reviews LEFT OUTER JOIN users ON reviews.user_id = users.id
SQL;

        return DB::select($sql, [$gameId]);
    }

    /**
     * 下書きを取得
     *
     * @param $userId
     * @param $gameId
     */
    public function getDraft($userId, $gameId)
    {
        if ($userId == null) {
            return ReviewDraft::getDefault($userId, $gameId);
        }

        $draft = ReviewDraft::where('user_id', $userId)
            ->where('game_id', $gameId)
            ->first();

        return $draft ?? ReviewDraft::getDefault($userId, $gameId);
    }

    /**
     * 保存
     *
     * @param InputRequest $request
     * @return bool|mixed
     */
    public function save(InputRequest $request)
    {
        $orm = new \Hgs3\Models\Orm\Review;

        $orm->user_id = \Auth::id();
        $orm->game_id = $request->get('game_id');
        $orm->package_id = $request->get('package_id');
        $orm->play_time = $request->get('play_time') ?? 0;
        $orm->title = $request->get('title') ?? '';
        $orm->fear = $request->get('fear') ?? 0;
        $orm->story = $request->get('story') ?? 0;
        $orm->volume = $request->get('volume') ?? 0;
        $orm->difficulty = $request->get('difficulty') ?? 0;
        $orm->graphic = $request->get('graphic') ?? 0;
        $orm->sound = $request->get('sound') ?? 0;
        $orm->crowded = $request->get('crowded') ?? 0;
        $orm->controllability = $request->get('controllability') ?? 0;
        $orm->recommend = $request->get('recommend') ?? 0;
        $orm->thoughts = $request->get('thoughts') ?? '';
        $orm->recommendatory = $request->get('recommendatory') ?? '';

        DB::beginTransaction();
        try {
            // 保存
            $orm->save();

            // 統計
            ReviewTotal::calculate($orm->game_id);

            // 下書き削除
            DB::table('review_drafts')
                ->where('user_id', $orm->user_id)
                ->where('game_id', $orm->game_id)
                ->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return $orm->id;
    }

    /**
     * 新着順レビューを取得(全ゲーム)
     *
     * @param $num
     * @return array
     */
    public function getNewArrivalsAll($num)
    {
        $sql =<<< SQL
SELECT
  review.*
  , users.name AS user_name
  , games.name AS game_name
  , game_packages.item_url
  , game_packages.small_image_url
FROM (
    SELECT id, point, user_id, post_date, title, game_id
    FROM reviews
    ORDER BY id DESC
    LIMIT {$num}
  ) review LEFT OUTER JOIN users ON review.user_id = users.id
  LEFT OUTER JOIN games ON games.id = review.game_id
  LEFT OUTER JOIN game_packages ON games.original_package_id = game_packages.id
SQL;

        return DB::select($sql);
    }

    /**
     * ポイントの高いゲームを取得
     *
     * @param $num
     * @return array
     */
    public function getHighScore($num)
    {
        $sql =<<< SQL
SELECT
  review.*
  , games.name AS game_name
  , game_packages.item_url
  , game_packages.small_image_url
FROM (
  SELECT point, game_id
  FROM review_totals
  ORDER BY point DESC
  LIMIT {$num}
) review LEFT OUTER JOIN games ON games.id = review.game_id
  LEFT OUTER JOIN game_packages ON games.original_package_id = game_packages.id
SQL;

        return DB::select($sql);
    }

    /**
     * いいねのレビューを取得
     *
     * @param $num
     * @return array
     */
    public function getManyGood($num)
    {
        $sql =<<< SQL
SELECT
  review.*
  , users.name AS user_name
  , game_packages.name AS game_name
  , game_packages.item_url
  , game_packages.small_image_url
FROM (
    SELECT id, point, user_id, post_date, title, game_id
    FROM reviews
    ORDER BY latest_good_num DESC
    LIMIT {$num}
  ) review LEFT OUTER JOIN users ON review.user_id = users.id
  LEFT OUTER JOIN games ON games.id = review.game_id
  LEFT OUTER JOIN game_packages ON games.original_package_id = game_packages.id
SQL;

        return DB::select($sql);
    }

    /**
     * いいね済か
     *
     * @param $reviewId
     * @param $userId
     */
    public function hasGood($reviewId, $userId)
    {
        return DB::table('review_good_histories')
            ->where('review_id', $reviewId)
            ->where('user_id', $userId)
            ->count() == 1;
    }

    /**
     * いいね
     *
     * @param \Hgs3\Models\Orm\Review $orm
     * @param $userId
     * @return bool
     */
    public function good(\Hgs3\Models\Orm\Review $orm, $userId)
    {
        DB::beginTransaction();
        try {
            $sql =<<< SQL
INSERT IGNORE INTO review_good_histories (review_id, user_id, good_date, created_at, updated_at)
VALUES (?, ?, NOW(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
SQL;
            $insNum = DB::insert($sql, [$orm->id, $userId]);
            if ($insNum == 1) {
                $updateGoodNum =<<< SQL
UPDATE reviews
SET good_num = good_num + 1
    , latest_good_num = latest_good_num + 1
WHERE id = ?
SQL;
                DB::update($updateGoodNum, [$orm->id]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }

        return true;
    }

    /**
     * いいね取り消し
     *
     * @param \Hgs3\Models\Orm\Review $orm
     * @param $userId
     * @return bool
     */
    public function cancelGood(\Hgs3\Models\Orm\Review $orm, $userId)
    {
        DB::beginTransaction();
        try {
            // 履歴を消す
            $sql =<<< SQL
DELETE FROM review_good_histories
WHERE review_id = ? AND user_id = ?
SQL;
            $delNum = DB::delete($sql, [$orm->id, $userId]);

            // 1件消されていたら数の再計算
            if ($delNum == 1) {
                $this->calculateGoodNum($orm->id);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }

        return true;
    }

    /**
     * いいね数を履歴から再計算
     *
     * @param $reviewId
     */
    public function calculateGoodNum($reviewId)
    {
        $totalGoodNum = Db::table('review_good_histories')
            ->where('review_id', $reviewId)
            ->count();

        $now = new \DateTime();
        $now->sub(new \DateInterval('P30D'));

        $latestGoodNum = Db::table('review_good_histories')
            ->where('review_id', $reviewId)
            ->where('good_date', '>=', $now->format('Y-m-d 00:00:00'))
            ->count();

        DB::table('reviews')
            ->where('id', $reviewId)
            ->update([
                'good_num'        => $totalGoodNum,
                'latest_good_num' => $latestGoodNum
            ]);
    }

    /**
     * いいね履歴を取得する
     *
     * @param $reviewId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getGoodHistory($reviewId)
    {
        return DB::table('review_good_histories')
            ->where('review_id', $reviewId)
            ->orderBy('good_date', 'DESC')
            ->paginate(20);
    }
}