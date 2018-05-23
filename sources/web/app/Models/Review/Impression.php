<?php
/**
 * レビュー印象モデル
 */


namespace Hgs3\Models\Review;

use Hgs3\Log;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
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
        return self::get($userId, $reviewId) != 0;
    }

    /**
     * 印象を取得
     *
     * @param $userId
     * @param $reviewId
     * @return int|mixed
     */
    public static function get($userId, $reviewId)
    {
        $his = Orm\ReviewImpressionHistory::where('user_id', $userId)
            ->where('review_id', $reviewId)
            ->first();

        return $his->fmfm_or_n ?? 0;
    }

    /**
     * ふむふむ
     *
     * @param User $user
     * @param Orm\Review $review
     * @throws \Exception
     */
    public static function fmfm(User $user, Orm\Review $review)
    {
        DB::beginTransaction();

        try {
            DB::table('reviews')
                ->where('id', $review->id)
                ->update(['fmfm_num' => DB::raw('fmfm_num + 1')]);

            // 基本的にエラーがなければ、データが存在した状態で印象を投稿することはないはず
            Orm\ReviewImpressionHistory::updateOrInsert(
                ['user_id' => $user->id, 'review_id' => $review->id],
                ['fmfm_or_n' => 1]
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);
        }
    }

    /**
     * んー…
     *
     * @param User $user
     * @param Orm\Review $review
     * @throws \Exception
     */
    public static function n(User $user, Orm\Review $review)
    {
        DB::beginTransaction();

        try {
            DB::table('reviews')
                ->where('id', $review->id)
                ->update(['n_num' => DB::raw('n_num + 1')]);

            // 基本的にエラーがなければ、データが存在した状態で印象を投稿することはないはず
            Orm\ReviewImpressionHistory::updateOrInsert(
                ['user_id' => $user->id, 'review_id' => $review->id],
                ['fmfm_or_n' => 2]
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);
        }
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
            DB::table('review_impression_histories')
                ->where('user_id', $user->id)
                ->where('review_id', $review->id)
                ->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);
        }
    }
}
