<?php
/**
 * レビューいいねのテストデータ生成
 */


namespace Hgs3\Models\Test;
use Hgs3\Models\Game\Review;
use Illuminate\Support\Facades\DB;

class ReviewGoodHistory
{
    /**
     * テストデータ生成
     *
     * @param $num
     */
    public static function create($num)
    {
        $users = User::getIds();
        $userNum = count($users);

        $reviews = DB::table('reviews')
            ->select('id')
            ->get()
            ->pluck('id');

        $r = new Review;

        foreach ($reviews as $reviewId) {
            for ($i = 0; $i < $num; $i++) {
                $sql =<<< SQL
INSERT IGNORE INTO review_good_histories
VALUES(?, ?, NOW(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
SQL;
                DB::insert($sql, [$reviewId, $users[rand(0, $userNum - 1)]]);
            }

            $r->calculateGoodNum($reviewId);
        }
    }
}