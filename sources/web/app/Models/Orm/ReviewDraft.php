<?php
/**
 * ORM: review_drafts
 */

namespace Hgs3\Models\Orm;
use Hgs3\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReviewDraft extends \Eloquent
{
    protected $primaryKey = ['user_id', 'soft_id'];
    public $incrementing = false;
    protected $guarded = ['user_id', 'soft_id'];

    public $isDefault = false;
    private $goodTags = null;
    private $veryGoodTags = null;
    private $badTags = null;
    private $veryBadTags = null;

    /**
     * デフォルト値が設定されているインスタンスを取得
     *
     * @param int $userId
     * @param int $softId
     * @return ReviewDraft
     */
    public static function getDefault($userId, $softId)
    {
        $draft = new self([
            'fear'            => 4,
            'url'             => '',
            'progress'        => '',
            'good_comment'    => '',
            'bad_comment'     => '',
            'general_comment' => '',
            'is_spoiler'      => 0,
            'package_id'      => json_encode([]),
        ]);

        $draft->user_id = $userId;
        $draft->soft_id = $softId;
        $draft->isDefault = true;

        return $draft;
    }

    /**
     * データを取得
     *
     * @param int $userId
     * @param int $softId
     * @return Model|static
     */
    public static function getData($userId, $softId)
    {
        $draft = self::where('soft_id', $softId)
            ->where('user_id', $userId)
            ->first();

        return $draft ?? self::getDefault($userId, $softId);
    }

    /**
     * 良いタグ
     *
     * @return array|null
     */
    public function getGoodTags()
    {
        if ($this->isDefault) {
            return [];
        }
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
        if ($this->isDefault) {
            return [];
        }
        $this->setTags();

        return $this->veryGoodTags;
    }

    /**
     * 悪いタグ
     *
     * @return array|null
     */
    public function getBadTags()
    {
        if ($this->isDefault) {
            return [];
        }
        $this->setTags();

        return $this->badTags;
    }

    /**
     * 特に悪いタグ
     *
     * @return array|null
     */
    public function getVeryBadTags()
    {
        if ($this->isDefault) {
            return [];
        }

        $this->setTags();

        return $this->veryBadTags;
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

        $tags = ReviewDraftTag::where('soft_id', $this->soft_id)
            ->where('user_id', $this->user_id)
            ->get();

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


    /**
     * 下書き削除
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        $result = true;

        DB::beginTransaction();
        try {
            // タグを削除
            ReviewDraftTag::where('user_id', $this->user_id)
                ->where('soft_id', $this->soft_id)
                ->delete();

            // 下書きを削除
            $result = parent::delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);
        }

        return $result;
    }

    /**
     * updateができないので、オーバーロードして実装
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        if ($this->exists) {
            $data = $this->toArray();
            unset($data['user_id']);
            unset($data['soft_id']);
            unset($data['updated_at']);
            unset($data['created_at']);

            DB::table('review_drafts')
                ->where('user_id', $this->user_id)
                ->where('soft_id', $this->soft_id)
                ->update($data);
            return true;
        } else {
            return parent::save($options);
        }
    }

    public function calcPoint()
    {
        $this->setTags();

        return $this->fear * 5 + (count($this->goodTags) + (count($this->veryGoodTags) * 2))
            - (count($this->badTags) + (count($this->veryBadTags) * 2));
    }
}
