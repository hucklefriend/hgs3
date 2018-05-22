<?php
/**
 * レビュー印象モデル
 */


namespace Hgs3\Models\Review;

use Hgs3\Log;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;

class Impression
{
    /**
     * 印象投稿済みか
     *
     * @param $userId
     * @param $reviewId
     * @return bool
     */
    public static function has($userId, $reviewId)
    {
        return Orm\ReviewImpressionHistory::where('user_id', $userId)
            ->where('review_id', $reviewId)
            ->get()
            ->count() > 0;
    }

    /**
     * ふむふむ
     *
     * @param User $user
     * @param Orm\Review $review
     */
    public static function fmfm(User $user, Orm\Review $review)
    {

    }

    /**
     * んー
     *
     * @param User $user
     * @param Orm\Review $review
     */
    public static function n(User $user, Orm\Review $review)
    {

    }

    /**
     * 現在の評価を削除
     *
     * @param User $user
     * @param Orm\Review $review
     * @throws \Exception
     */
    public static function cancel(User $user, Orm\Review $review)
    {
        $his = Orm\ReviewImpressionHistory::where('user_id', $user->id)
            ->where('review_id', $review->id)
            ->first();

        // 履歴にないなら削除しない(できない)
        if (empty($his)) {
            return;
        }

        // 減らす列
        $subColumn = $his->fmfm_or_n == 1 ? 'fmfm_num' : 'n_num';

        DB::beginTransaction();

        try {
            // 数を減らす
            DB::table('reviews')
                ->where('id', $review->id)
                ->update([$subColumn => DB::raw($subColumn . ' - 1')]);

            // 履歴を削除
            $his->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);
        }
    }
}
