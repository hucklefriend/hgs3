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
    public static function approveUrl($reviewId)
    {
        $review = Orm\Review::find($reviewId);
        $review->enable_url = 1;
        $review->save();

        // TODO タイムラインにURLがOKとなったことを通知

        // TODO メッセージを投げる
    }

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