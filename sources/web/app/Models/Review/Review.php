<?php
/**
 * レビューモデル
 */


namespace Hgs3\Models\Review;

use Hgs3\Http\Requests\Review\WriteRequest;
use Hgs3\Models\Orm\GamePackage;
use Hgs3\Models\Orm\ReviewDraft;
use Hgs3\Models\Orm\ReviewTotal;
use Hgs3\Models\Timeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Review
{
    /**
     * 新着順レビューを取得
     *
     * @param $gameId
     * @param $num
     * @param $offset
     */
    public function getNewArrivals($gameId, $num, $offset = 0)
    {
        $sql =<<< SQL
SELECT
  reviews.*
  , users.name AS user_name
  , pkg.name game_name
  , pkg.game_type_id
  , pkg.small_image_url
FROM (
    SELECT id, point, user_id, post_date, title, good_num, package_id, is_spoiler
    FROM reviews
    WHERE game_id = ?
    ORDER BY id DESC
    LIMIT {$num}
    OFFSET {$offset}
  ) reviews LEFT OUTER JOIN users ON reviews.user_id = users.id
  LEFT OUTER JOIN game_packages pkg ON pkg.id = reviews.package_id
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

        return $draft;
    }

    /**
     * 保存
     *
     * @param WriteRequest $request
     * @param ReviewDraft $draft
     * @return bool|mixed
     */
    public function save(WriteRequest $request, ReviewDraft $draft)
    {
        $orm = new \Hgs3\Models\Orm\Review($draft->toArray());
        $orm->post_date = new \DateTime();

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

            // タイムライン登録
            Timeline::addNewReviewText($orm->id, $orm->user_id, null, $orm->game_id, null);

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
    SELECT id, point, user_id, post_date, title, game_id, good_num, is_spoiler
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
  SELECT *
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
    SELECT id, point, user_id, post_date, title, game_id, latest_good_num, good_num, is_spoiler
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

                // タイムライン
                Timeline::addReviewGoodText($orm->id, $userId, null, $orm->user_id);
            }

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

    /**
     * ユーザー別データ取得
     *
     * @param $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUser($userId)
    {
        $data = DB::table('reviews')
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->paginate(20);

        $packages = GamePackage::getHash(array_pluck($data->items(), 'package_id'));
        foreach ($data as &$row) {
            if (isset($packages[$row->package_id])) {
                $row->game_name = $packages[$row->package_id]->name;
                $row->small_image_url = $packages[$row->package_id]->small_image_url;
            } else {
                $row->game_name = '';
                $row->small_image_url = null;
            }
        }

        return $data;
    }

    /**
     * パッケージのリストを取得
     *
     * @param $gameId
     * @return array
     */
    public function getPackageList($gameId)
    {
        $sql =<<< SQL
SELECT
  pkg.*
  , p.name platform_name
  , c.name company_name
FROM  (
  SELECT id, platform_id, name, small_image_url, item_url, company_id
  FROM game_packages
  WHERE game_id = ?
  ORDER BY release_int
) pkg INNER JOIN game_platforms p ON pkg.platform_id = p.id
  LEFT OUTER JOIN game_companies c ON c.id = pkg.company_id
SQL;

        return DB::select($sql, [$gameId]);
    }
}