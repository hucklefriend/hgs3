<?php
/**
 * レビュー集計フラグモデル
 */


namespace Hgs3\Models\Review;

use Hgs3\Log;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;

class Approval
{
    /**
     * URLを承認
     *
     * @param $reviewId
     * @throws \Exception
     */
    public static function approveUrl($reviewId)
    {
        DB::beginTransaction();

        try {
            DB::table('reviews')
                ->where('id', $reviewId)
                ->update(['enable_url' => 1]);

            DB::table('review_wait_urls')
                ->where('review_id', $reviewId)
                ->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::exceptionError($e);
        }



        // TODO タイムラインにURLがOKとなったことを通知

        // TODO メッセージを投げる
    }

    /**
     * URLを否認
     *
     * @param $reviewId
     */
    public static function denyUrl($reviewId)
    {
        $review = Orm\Review::find($reviewId);

        // TODO タイムラインにURLがNGとなったことを通知

        // TODO メッセージを投げる
    }

    public static function injustice($reviewId)
    {

    }
}