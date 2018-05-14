<?php
/**
 * レビュー集計フラグモデル
 */


namespace Hgs3\Models\Review;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;

class Total
{
    /**
     * レビューの集計
     */
    public static function total()
    {
        // 集計対象を取得
        $targetReviews = Orm\ReviewTotalFlag::where('total_flag', 1)->get();
        if ($targetReviews->count() == 0) {
            return;
        }

        $soft_ids = implode(', ', $targetReviews->pluck('soft_id'));

        $sql =<<< SQL
INSERT INTO review_totals
soft_id, fear, good_tag_num, very_good_tag_num, bad_tag_num, very_bad_tag_num, point, review_num, created_at, updated_at

SELECT *
(
  SELECT soft_id, AVG(fear) AS fear, AVG(good_tag_num) AS good_tag_num,
    AVG(very_good_tag_num) AS very_good_tag_num, AVG(bad_tag_num) AS bad_tag_num,
    AVG(very_bad_tag_num) AS very_bad_tag_num, AVG(point) AS point,
    COUNT(id) AS review_num, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP 
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

        DB::insert($sql);
    }
}