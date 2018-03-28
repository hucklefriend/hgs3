<?php
/**
 * レビューモデル
 */


namespace Hgs3\Models;

use Hgs3\Constants\Review\Status;
use Hgs3\Models\Orm;
use Hgs3\Models\Timeline;
use Illuminate\Support\Facades\DB;
use Hgs3\Log;

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
        $tagData = [];

        // 良いところ
        foreach ($goodTags as $goodTag) {
            $tagData[$goodTag] = [
                'soft_id' => $draft->soft_id,
                'user_id' => $draft->user_id,
                'tag'     => $goodTag,
                'point'   => 1
            ];
        }

        // 特に優れているところ
        foreach ($veryGoodTags as $veryGoodTag) {
            if (isset($tagData[$veryGoodTag])) {
                $tagData[$veryGoodTag]['point'] = 2;
            }
        }

        // 悪いところ
        foreach ($badTags as $badTag) {
            $tagData[$badTag] = [
                'soft_id' => $draft->soft_id,
                'user_id' => $draft->user_id,
                'tag'     => $badTag,
                'point'   => -1
            ];
        }

        // 特にわるいところ
        foreach ($veryBadTags as $veryBadTag) {
            if (isset($tagData[$veryBadTag])) {
                $tagData[$veryBadTag]['point'] = -2;
            }
        }

        DB::beginTransaction();
        try {
            Orm\ReviewDraftTag::where('user_id', $draft->user_id)
                ->where('soft_id', $draft->soft_id)
                ->delete();

            Orm\ReviewDraftTag::insert($tagData);

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
     * @param Orm\ReviewDraft $draft
     * @throws \Exception
     */
    public static function open(Orm\ReviewDraft $draft)
    {
        $review = new Orm\Review();
        $review->user_id = $draft->user_id;
        $review->package_id = $draft->package_id;
        $review->fear = $draft->fear;
        $review->url = $draft->url;
        $review->progress = $draft->progress;
        $review->good_comment = $draft->good_comment;
        $review->bad_comment = $draft->bad_comment;
        $review->general_comment = $draft->general_comment;
        $review->is_spoiler = $draft->is_spoiler;

        $goodTags = $draft->getGoodTags();
        $veryGoodTags = $draft->getVeryGoodTags();
        $badTags = $draft->getBadTags();
        $veryBadTags = $draft->getVeryBadTags();

        $review->good_tag_num = count($goodTags);
        $review->very_good_tag_num = count($veryGoodTags);
        $review->bad_tag_num = count($badTags);
        $review->very_bad_tag_num = count($veryBadTags);

        $review->post_at = date('Y-m-d H:i:s');
        $review->status = Status::OPEN;

        DB::beginTransaction();

        try {
            // レビューに登録
            $review->save();

            // タグに登録


            // 集計してねフラグを立てる
            self::upTotalFlag($draft->soft_id);

            // 下書きの公開済みフラグをアップ
            $draft->opended_flag = 1;
            $draft->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);
        }

        // タイムラインに登録
    }

    private static function upTotalFlag($softId)
    {
        $sql =<<< SQL
INSERT INTO review_total_flags (soft_id, flag, created_at, updated_at)
VALUES (:soft_id, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
ON DUPLICATE KEY UPDATE
  flag = 1
  , updated_at = CURRENT_TIMESTAMP
SQL;

        DB::insert($sql, ['soft_id' => $softId]);
    }
}