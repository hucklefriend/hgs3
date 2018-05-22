<?php
/**
 * ORM: reviews
 */

namespace Hgs3\Models\Orm;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Hgs3\Log;

class Review extends \Eloquent
{
    protected $guarded = ['id'];

    public $goodTags = null;
    public $veryGoodTags = null;
    public $badTags = null;
    public $veryBadTags = null;

    /**
     * 保存
     *
     * @param array $options
     * @return bool
     * @throws \Exception
     */
    public function save(array $options = [])
    {
        $isNew = $this->id === null;

        $this->good_tag_num = count($this->goodTags);
        $this->very_good_tag_num = count($this->veryGoodTags);
        $this->bad_tag_num = count($this->badTags);
        $this->very_bad_tag_num = count($this->veryBadTags);


        if ($isNew) {
            // 新規登録
            $this->sort_order = 0;
            $this->good_num = 0;
            $this->post_at = new \DateTime();
            $this->update_num = 0;
        } else {
            // データ修正
            $this->update_num++;
        }

        parent::save($options);

        $good = [];
        $bad = [];

        // 良いところ
        foreach ($this->goodTags as $goodTag) {
            $good[$goodTag] = [
                'review_id' => $this->id,
                'tag'       => $goodTag,
                'point'     => 1
            ];
        }

        // 特に優れているところ
        foreach ($this->veryGoodTags as $veryGoodTag) {
            if (isset($good[$veryGoodTag])) {
                $good[$veryGoodTag]['point'] = 2;
            }
        }

        // 悪いところ
        foreach ($this->badTags as $badTag) {
            $bad[$badTag] = [
                'review_id' => $this->id,
                'tag'       => $badTag,
                'point'     => -1
            ];
        }

        // 特にわるいところ
        foreach ($this->veryBadTags as $veryBadTag) {
            if (isset($bad[$veryBadTag])) {
                $bad[$veryBadTag]['point'] = -2;
            }
        }

        ReviewTag::where('review_id', $this->id)->delete();
        ReviewTag::insert($good);
        ReviewTag::insert($bad);

        return true;
    }


    /**
     * レビュー削除
     *
     * @return bool|null|void
     * @throws \Exception
     */
    public function delete()
    {
        DB::beginTransaction();
        try {
            // 履歴を削除
            ReviewImpressionHistory::where('review_id')
                ->delete();

            // TODO 不正報告を削除

            $gameId = $this->gameId;
            parent::delete();

            // 累計データの修正
            ReviewTotal::calculate($gameId);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::exceptionError($e);
        }
    }

    /**
     * 特定ユーザーが持っているサイト数を取得
     *
     * @param $userId
     * @return int
     */
    public static function getNumByUser($userId)
    {
        return self::where('user_id', $userId)
            ->where('status', \Hgs3\Constants\Review\Status::OPEN)
            ->count('id');
    }

    /**
     * ポイントを計算
     *
     * @return int|mixed
     */
    public function calcPoint()
    {
        return $this->point;
    }

    /**
     * 公開日を取得
     *
     * @return string
     */
    public function getOpenDate()
    {
        return format_date(strtotime($this->post_at));
    }

    /**
     * 良いタグ
     *
     * @return array|null
     */
    public function getGoodTags()
    {
        $this->setTags();

        return $this->goodTags;
    }

    /**
     * とても良いタグ
     *
     * @return array|null
     */
    public function getVeryGoodTags()
    {
        $this->setTags();

        return $this->veryGoodTags;
    }

    /**
     * とても良いタグに指定されているか？
     *
     * @param $tagId
     * @return bool
     */
    public function isVeryGood($tagId)
    {
        return in_array($tagId, $this->veryGoodTags);
    }

    /**
     * 悪いタグ
     *
     * @return array|null
     */
    public function getBadTags()
    {
        $this->setTags();

        return $this->badTags;
    }

    /**
     * とても悪いタグ
     *
     * @return array|null
     */
    public function getVeryBadTags()
    {
        $this->setTags();

        return $this->veryBadTags;
    }

    /**
     * とても悪いタグに指定されているか？
     *
     * @param $tagId
     * @return bool
     */
    public function isVeryBad($tagId)
    {
        return in_array($tagId, $this->veryBadTags);
    }

    /**
     * タグをセット
     */
    private function setTags()
    {
        if ($this->goodTags !== null) {
            return;
        }

        $this->goodTags = [];
        $this->veryGoodTags = [];
        $this->badTags = [];
        $this->veryBadTags = [];

        $tags = ReviewTag::where('review_id', $this->id)->get();
        foreach ($tags as $tag) {
            switch ($tag->point) {
                case 1:
                    $this->goodTags[] = $tag->tag;
                    break;
                case 2:
                    $this->goodTags[] = $tag->tag;
                    $this->veryGoodTags[] = $tag->tag;
                    break;
                case -1:
                    $this->badTags[] = $tag->tag;
                    break;
                case -2:
                    $this->badTags[] = $tag->tag;
                    $this->veryBadTags[] = $tag->tag;
                    break;
            }
        }
    }

    /**
     * パッケージの配列を取得
     *
     * @return Collection|static[]
     */
    public function getPackages()
    {
        $arr = json_decode($this->package_id, true);

        if (empty($arr)) {
            return new Collection();
        }

        return GamePackage::whereIn('id', $arr)
            ->get();
    }
}
