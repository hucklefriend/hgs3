<?php
/**
 * レビューモデル
 */


namespace Hgs3\Models;

use Hgs3\Constants\Review\Status;
use Hgs3\Models\Orm;
use Hgs3\Models\Timeline;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Hgs3\Log;
use Illuminate\Support\Facades\Mail;

class Review
{
    /**
     * 下書き保存
     *
     * @param Orm\ReviewDraft $draft
     * @param array $goodTags
     * @param array $veryGoodTags
     * @param array $badTags
     * @param array $veryBadTags
     * @throws \Exception
     */
    public static function saveDraft(Orm\ReviewDraft $draft, array $goodTags, array $veryGoodTags, array $badTags, array $veryBadTags)
    {
        $good = [];
        $bad = [];

        // 良いところ
        foreach ($goodTags as $goodTag) {
            $good[$goodTag] = [
                'soft_id' => $draft->soft_id,
                'user_id' => $draft->user_id,
                'tag'     => $goodTag,
                'point'   => 1
            ];
        }

        // 特に優れているところ
        foreach ($veryGoodTags as $veryGoodTag) {
            if (isset($good[$veryGoodTag])) {
                $good[$veryGoodTag]['point'] = 2;
            }
        }

        // 悪いところ
        foreach ($badTags as $badTag) {
            $bad[$badTag] = [
                'soft_id' => $draft->soft_id,
                'user_id' => $draft->user_id,
                'tag'     => $badTag,
                'point'   => -1
            ];
        }

        // 特にわるいところ
        foreach ($veryBadTags as $veryBadTag) {
            if (isset($bad[$veryBadTag])) {
                $bad[$veryBadTag]['point'] = -2;
            }
        }

        DB::beginTransaction();
        try {
            Orm\ReviewDraftTag::where('user_id', $draft->user_id)
                ->where('soft_id', $draft->soft_id)
                ->delete();

            Orm\ReviewDraftTag::insert($good);
            Orm\ReviewDraftTag::insert($bad);

            $draft->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);
        }
    }

    /**
     * 下書きを公開
     *
     * @param Orm\GameSoft $soft
     * @param Orm\ReviewDraft $draft
     * @throws \Exception
     */
    public static function open(Orm\GameSoft $soft, Orm\ReviewDraft $draft)
    {
        $review = new Orm\Review();
        $review->user_id = $draft->user_id;
        $review->soft_id = $soft->id;
        $review->package_id = $draft->package_id;
        $review->fear = $draft->fear;
        $review->url = $draft->url;
        $review->enable_url = 0;
        $review->progress = $draft->progress;
        $review->good_comment = $draft->good_comment;
        $review->bad_comment = $draft->bad_comment;
        $review->general_comment = $draft->general_comment;
        $review->is_spoiler = $draft->is_spoiler;

        $review->goodTags = $draft->getGoodTags();
        $review->veryGoodTags = $draft->getVeryGoodTags();
        $review->badTags = $draft->getBadTags();
        $review->veryBadTags = $draft->getVeryBadTags();

        $review->post_at = date('Y-m-d H:i:s');
        $review->point = $draft->calcPoint();

        $review->status = Status::OPEN;

        DB::beginTransaction();

        try {
            // レビューに登録
            $review->save();

            // レビューURL確認待ち
            if (!empty($review->url)) {
                Orm\ReviewWaitUrl::insert(['review_id' => $review->id]);
            }

            // 集計してねフラグを立てる
            self::upTotalFlag($draft->soft_id);

            // 下書きを削除
            $draft->deleteWithTag();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);
        }

        // タイムラインに登録
        $user = User::find($review->user_id);
        Timeline\FollowUser::addWriteReviewText($user, $soft, $review);
        Timeline\ToMe::addWriteReviewText($user, $soft, $review);

        if (!empty($review->url)) {
            // 管理人のタイムラインに流す
            $admin = User::getAdmin();
            Timeline\ToMe::addReviewUrlApproveText($admin, $review);

            // 管理人にメール送信
            if (env('APP_ENV') == 'production') {
                Mail::to(env('ADMIN_MAIL'))
                    ->send(new \Hgs3\Mail\ReviewUrlApprovalWait());

                Log::info('管理人にメール飛ばした');
            }
        }
    }

    /**
     * 集計してくださいフラグを立てる
     *
     * @param $softId
     */
    private static function upTotalFlag($softId)
    {
        $sql =<<< SQL
INSERT INTO review_total_flags (soft_id, total_flag, created_at, updated_at)
VALUES (:soft_id, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
ON DUPLICATE KEY UPDATE
  total_flag = 1
  , updated_at = CURRENT_TIMESTAMP
SQL;

        DB::insert($sql, ['soft_id' => $softId]);
    }

    /**
     * プロフィールページ用の一覧を取得
     *
     * @param User $user
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getProfileList(User $user)
    {
        \ChromePhp::info($user->id);

        $data = Orm\Review::where('user_id', $user->id)
            ->orderBy('id', 'DESC')
            ->paginate(20);

        if (empty($data->items())) {
            return $data;
        }

        $softIds = array_pluck($data->items(), 'soft_id');
        $soft = Orm\GameSoft::getHash($softIds);
        foreach ($data->items() as &$review) {
            $review->soft = $soft[$review->soft_id];


        }

        return $data;
    }

    /**
     * いいね済みか
     *
     * @param $userId
     * @param $reviewId
     * @return bool
     */
    public static function hasGood($userId, $reviewId)
    {
        return Orm\ReviewGoodHistory::where('review_id', $reviewId)
            ->where('user_id', $userId)
            ->get()->count() > 0;
    }

    /**
     * いいね
     *
     * @param Orm\Review $review
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public static function good(Orm\Review $review, User $user)
    {
        $sql =<<< SQL
INSERT IGNORE INTO review_good_histories (
  review_id, user_id, good_at, created_at, updated_at
) VALUES (
  :review_id, :user_id, NOW(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
)
SQL;

        $prevMaxGoodNum = $review->max_good_num;

        try {
            DB::insert($sql, [
                'review_id' => $review->id,
                'user_id'   => $user->id
            ]);

            DB::table('reviews')
                ->where('id', $review->id)
                ->update([
                    'good_num' => DB::raw('good_num + 1')
                ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);
        }

        // TODO タイムラインに登録
        $reviewUser = User::find($review->user_id);
        $soft = Orm\GameSoft::find($review->soft_id);
        Timeline\ToMe::addReviewGoodText($reviewUser, $review, $soft, $user);
        Timeline\ToMe::addReviewGoodNumText($reviewUser, $review, $soft, $prevMaxGoodNum);

        return true;
    }

    /**
     * いいね取り消し
     *
     * @param Orm\Review $review
     * @param User $user
     * @throws \Exception
     * @return bool
     */
    public static function cancelGood(Orm\Review $review, User $user)
    {
        DB::beginTransaction();

        try {
            Orm\ReviewGoodHistory::where('review_id', $review->id)
                ->where('user_id', $user->id)
                ->delete();

            DB::table('reviews')
                ->where('id', $review->id)
                ->update([
                    'good_num' => DB::raw('good_num - 1')
                ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);

            return true;
        }

        return true;
    }

    /**
     * 公開済みか？
     *
     * @param $userId
     * @param $softId
     * @return bool
     */
    public static function isOpened($userId, $softId)
    {
        return  Orm\Review::where('user_id', $userId)
            ->where('soft_id', $softId)
            ->count() > 0;
    }

    /**
     * 無効期間内か？
     *
     * @param $userId
     * @param $softId
     * @return bool
     * @throws \Exception
     */
    public static function isDisableTerm($userId, $softId)
    {
        $data = Orm\ReviewDisableTerm::where('user_id', $userId)
            ->where('soft_id', $softId)
            ->first();

        if (empty($data)) {
            return false;
        } else {
            $now = new \DateTime();
            $now->setTime(0, 0, 0);

            $limit = new \DateTime($data->start_date);
            $limit->add(new \DateInterval('P6M'));

            return $now < $limit;
        }
    }

    /**
     * レビュー削除
     *
     * @param User $user
     * @param Orm\Review $review
     * @throws \Exception
     */
    public static function delete(User $user, Orm\Review $review)
    {
        $softId = $review->soft_id;

        DB::beginTransaction();

        try {
            // いいね履歴を削除
            Orm\ReviewGoodHistory::where('review_id')
                ->delete();

            // TODO 不正申告を削除

            // レビューを削除
            $review->delete();

            // 累計データの再集計フラグを立てる
            self::upTotalFlag($softId);

            // 投稿できませんよ期間
            $sql =<<< SQL
INSERT INTO review_disable_terms (user_id, soft_id, start_date, created_at, updated_at)
VALUES (:user_id, :soft_id, CURRENT_DATE, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
ON DUPLICATE KEY UPDATE
  start_date = VALUES(start_date),
  updated_at = CURRENT_TIMESTAMP
SQL;

            DB::insert($sql, [
                'user_id' => $user->id,
                'soft_id' => $softId
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);
        }
    }
}