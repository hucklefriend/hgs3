<?php
/**
 * レビューモデル
 */


namespace Hgs3\Models;

use Hgs3\Constants\Review\Status;
use Hgs3\Models\Orm;
use Hgs3\Models\Timeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Review
{
    /**
     * データ数を取得
     *
     * @param $gameId
     * @return int
     */
    public function getNumByGame($gameId)
    {
        return DB::table('reviews')
            ->select(['id'])
            ->where('soft_id', $gameId)
            ->where('status', Status::OPEN)
            ->count(['id']);
    }

    /**
     * レビュートップページ用のデータを取得する
     *
     * @param int $num
     * @return array
     */
    public static function getTopPageData($num)
    {
        $data = [];

        // 新着レビュー
        $data['newArrivals'] = self::getNewArrivals($num);

        // 評価の高いゲームソフト
        $data['highScore'] = self::getHighScore($num);

        // 直近1ヶ月のいいねが多いレビュー
        $data['manyGood'] = self::getManyGood($num);

        return $data;
    }

    /**
     * 新着順レビューを取得(全ゲーム)
     *
     * @param $num
     * @return array
     */
    private static function getNewArrivals($num)
    {
        // TODO statusで絞り込み

        $sql =<<< SQL
SELECT
  review.*
  , users.name AS user_name
  , game_packages.name AS package_name
  , game_packages.small_image_url
FROM (
    SELECT id, point, user_id, post_at, title, soft_id, good_num, is_spoiler, package_id
    FROM reviews
    ORDER BY id DESC
    LIMIT {$num}
  ) review LEFT OUTER JOIN users ON review.user_id = users.id
  LEFT OUTER JOIN game_packages ON review.package_id = game_packages.id
SQL;

        return DB::select($sql);
    }

    /**
     * ポイントの高いゲームを取得
     *
     * @param $num
     * @return array
     */
    private static function getHighScore($num)
    {
        // TODO statusで絞り込み

        $sql =<<< SQL
SELECT
  review.*
  , softs.name AS soft_name
  , game_packages.small_image_url
FROM (
  SELECT *
  FROM review_totals
  ORDER BY point DESC
  LIMIT {$num}
) review LEFT OUTER JOIN game_softs AS softs ON softs.id = review.soft_id
  LEFT OUTER JOIN game_packages ON softs.original_package_id = game_packages.id
SQL;

        return DB::select($sql);
    }

    /**
     * 直近1ヶ月のいいねの多いレビューを取得
     *
     * @param $num
     * @return array
     */
    private static function getManyGood($num)
    {
        // TODO statusで絞り込み

        $sql =<<< SQL
SELECT
  review.*
  , users.name AS user_name
  , game_packages.name AS package_name
  , game_packages.small_image_url
FROM (
    SELECT id, point, user_id, post_at, title, soft_id, latest_good_num, good_num, is_spoiler, package_id
    FROM reviews
    ORDER BY latest_good_num DESC
    LIMIT {$num}
  ) review LEFT OUTER JOIN users ON review.user_id = users.id
  LEFT OUTER JOIN game_packages ON review.package_id = game_packages.id
SQL;

        return DB::select($sql);
    }

    /**
     * 特定ゲームソフトの新着順レビューを取得
     *
     * @param int $softId
     * @param int $num
     * @param int $offset
     * @return array
     */
    public static function getNewArrivalsBySoft($softId, $num, $offset = 0)
    {
        // TODO statusで絞り込み

        $sql =<<< SQL
SELECT
  reviews.*
  , users.name AS user_name
  , pkg.name AS package_name
  , pkg.is_adult
  , pkg.small_image_url
FROM (
    SELECT id, point, user_id, post_at, title, good_num, package_id, is_spoiler
    FROM reviews
    WHERE soft_id = ?
    ORDER BY id DESC
    LIMIT {$num}
    OFFSET {$offset}
  ) reviews LEFT OUTER JOIN users ON reviews.user_id = users.id
  LEFT OUTER JOIN game_packages pkg ON pkg.id = reviews.package_id
SQL;

        return DB::select($sql, [$softId]);
    }

    /**
     * 下書きを取得
     *
     * @param int $userId
     * @param int $softId
     * @param int $packageId
     * @return Orm\ReviewDraft|\Illuminate\Database\Eloquent\Model|null|static
     */
    public function getDraft($userId, $softId, $packageId)
    {
        if ($userId == null) {
            return Orm\ReviewDraft::getDefault($userId, $softId, $packageId);
        }

        $draft = Orm\ReviewDraft::where('user_id', $userId)
            ->where('soft_id', $softId)
            ->where('packge_id', $packageId)
            ->first();

        return $draft;
    }

    /**
     * 保存
     *
     * @param User $user
     * @param Orm\ReviewDraft $draft
     * @return bool|mixed
     */
    public function save(User $user, Orm\ReviewDraft $draft)
    {
        $review = new Orm\Review($draft->toArray());
        $review->post_at = new \DateTime();

        DB::beginTransaction();
        try {
            // 保存
            $review->save();

            // 統計
            Orm\ReviewTotal::calculate($review->soft_id);

            // 下書き削除
            DB::table('review_drafts')
                ->where('user_id', $review->user_id)
                ->where('package_id', $review->package_id)
                ->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        // タイムライン登録
        $soft = Orm\GameSoft::find($draft->soft_id);
        if ($soft !== null) {
            Timeline\FavoriteSoft::addNewReviewText($soft, $review);
            Timeline\FollowUser::addWriteReviewText($user, $soft, $review);
        }

        return $review->id;
    }

    /**
     * マイページ用のデータ取得
     *
     * @param $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getMyPage($userId)
    {
        return Orm\Review::where('user_id', $userId)
            ->orderBy('id')
            ->paginate(15);
    }

    /**
     * いいね済か
     *
     * @param int $reviewId
     * @param int $userId
     * @return bool
     */
    public function hasGood($reviewId, $userId)
    {
        return DB::table('review_good_histories')
            ->where('review_id', $reviewId)
            ->where('user_id', $userId)
            ->get()
            ->isNotEmpty();
    }

    /**
     * いいね
     *
     * @param Orm\Review $orm
     * @param User $user
     * @return bool
     */
    public function good(Orm\Review $orm, User $user)
    {
        $prevMaxGood = $orm->max_good_num;

        DB::beginTransaction();
        try {
            $sql =<<< SQL
INSERT IGNORE INTO review_good_histories (review_id, user_id, good_at, created_at, updated_at)
VALUES (?, ?, NOW(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
SQL;
            $insNum = DB::insert($sql, [$orm->id, $user->id]);
            if ($insNum == 1) {
                $orm->good_num++;
                $orm->latest_good_num++;
                if ($prevMaxGood < $orm->god_num) {
                    $orm->max_good_num = $orm->good_num;
                }

                $orm->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        // タイムライン
        $writer = User::find($orm->user_id);
        $package = Orm\GamePackage::find($orm->package_id);
        if ($writer != null && $package != null) {
            Timeline\ToMe::addReviewGoodText($writer, $orm, $package, $user);
            Timeline\ToMe::addReviewGoodNumText($writer, $orm, $package, $prevMaxGood);
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
            ->where('good_at', '>=', $now->format('Y-m-d 00:00:00'))
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
            ->orderBy('good_at', 'DESC')
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

        $packages = Orm\GamePackage::getHash(array_pluck($data->items(), 'package_id'));
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
  , p.acronym platform_name
  , c.name company_name
FROM  (
  SELECT id, platform_id, `name`, small_image_url, company_id, release_at, release_int
  FROM game_packages
  WHERE id IN (SELECT package_id FROM game_package_links WHERE soft_id = ?)
  ORDER BY release_int
) pkg INNER JOIN game_platforms p ON pkg.platform_id = p.id
  LEFT OUTER JOIN game_companies c ON c.id = pkg.company_id
SQL;

        return DB::select($sql, [$gameId]);
    }
}