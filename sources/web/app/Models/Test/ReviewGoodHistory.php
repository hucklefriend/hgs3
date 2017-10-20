<?php
/**
 * レビューいいねのテストデータ生成
 */


namespace Hgs3\Models\Test;
use Hgs3\Models\Review\Review;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm;

class ReviewGoodHistory
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create review good history test data.'.PHP_EOL;

        /*
        DB::table('review_good_histories')
            ->truncate();
        */

        $reviews = \Hgs3\Models\Test\Review::get();
        $users = User::get();
        $userMax = $users->count() - 1;
        $r = new Review;

        foreach ($reviews as $review) {
            $n = rand(1, 30);
            for ($i = 0; $i < $n; $i++) {
                $r->good($review, $users[rand(0, $userMax)]);
            }
        }

        unset($users);
        unset($r);
    }
}