<?php
/**
 * レビュー集計モデル
 */


namespace Hgs3\Models\Review;

use Hgs3\Log;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;

class Total
{
    /**
     * レビューの集計
     *
     * @throws \Exception
     */
    public static function total()
    {
        // 集計対象を取得
        $targetReviews = Orm\ReviewTotalFlag::where('total_flag', 1)->get();
        if ($targetReviews->count() == 0) {
            return;
        }

        $soft_ids = implode(', ', $targetReviews->pluck('soft_id')->toArray());

        $sql =<<< SQL
INSERT INTO review_totals
  (soft_id, fear, good_tag_num, very_good_tag_num, bad_tag_num, very_bad_tag_num,
  point, review_num, created_at, updated_at)

SELECT *
FROM (
  SELECT soft_id, AVG(fear) AS fear, AVG(good_tag_num) AS good_tag_num,
    AVG(very_good_tag_num) AS very_good_tag_num, AVG(bad_tag_num) AS bad_tag_num,
    AVG(very_bad_tag_num) AS very_bad_tag_num, AVG(point) AS point,
    COUNT(id) AS review_num, CURRENT_TIMESTAMP AS created_at, CURRENT_TIMESTAMP AS updated_at 
  FROM reviews
  WHERE soft_id IN ({$soft_ids})
  GROUP BY soft_id
) as reviews

ON DUPLICATE KEY UPDATE
    fear = VALUES(fear),
    good_tag_num = VALUES(good_tag_num),
    very_good_tag_num = VALUES(very_good_tag_num),
    bad_tag_num = VALUES(bad_tag_num),
    very_bad_tag_num = VALUES(very_bad_tag_num),
    point = VALUES(point),
    review_num = VALUES(review_num),
    updated_at = VALUES(updated_at)
SQL;

        DB::beginTransaction();
        try {
            DB::insert($sql);

            Orm\ReviewTotalFlag::whereIn('soft_id', $targetReviews->pluck('soft_id'))
                ->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::exceptionError($e);
        }

        self::fearRanking();
        self::pointRanking();
    }


    private static function fearRanking()
    {
        $sql =<<< SQL
SELECT soft_id, ROUND(fear * 10) AS fear
FROM review_totals
ORDER BY fear DESC
SQL;

        $data = DB::select($sql);

        $rank = 1;
        $sql =<<< SQL
INSERT INTO review_fear_rankings (
  rank, soft_id, fear, fear_face, created_at, updated_at
) VALUES 
SQL;

        DB::table('review_fear_rankings')->delete();

        $num = count($data);
        if ($num > 0) {
            $sql .= sprintf('(%d, %d, %d, %d, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)',
                $rank, $data[0]->soft_id, $data[0]->fear, round($data[0]->fear / 10));
        }

        $sameRankNum = 1;
        for ($i = 1; $i < $num; $i++) {
            if ($data[$i]->fear == $data[$i - 1]->fear) {
                $sameRankNum++;
            } else {
                $rank += $sameRankNum;
                $sameRankNum = 1;
            }


            $sql .= sprintf(', (%d, %d, %d, %d, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)',
                $rank, $data[$i]->soft_id, $data[$i]->fear, round($data[$i]->fear / 10));
        }

        DB::insert($sql);
    }


    private static function pointRanking()
    {
        $sql =<<< SQL
SELECT soft_id, ROUND(point) AS point
FROM review_totals
ORDER BY point DESC
SQL;

        $data = DB::select($sql);

        $rank = 1;
        $sql =<<< SQL
INSERT INTO review_point_rankings (
  rank, soft_id, point, created_at, updated_at
) VALUES 
SQL;

        DB::table('review_point_rankings')->delete();

        $num = count($data);
        if ($num > 0) {
            $sql .= sprintf('(%d, %d, %d, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)',
                $rank, $data[0]->soft_id, $data[0]->point);
        }

        $sameRankNum = 1;
        for ($i = 1; $i < $num; $i++) {
            if ($data[$i]->point == $data[$i - 1]->point) {
                $sameRankNum++;
            } else {
                $rank += $sameRankNum;
                $sameRankNum = 1;
            }

            $sql .= sprintf(', (%d, %d, %d, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)',
                $rank, $data[$i]->soft_id, $data[$i]->point);
        }

        DB::insert($sql);
    }
}