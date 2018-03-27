<?php
/**
 * ORM: review_drafts
 */

namespace Hgs3\Models\Orm;
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
            'is_spoiler'      => 0
        ]);

        $draft->user_id = $userId;
        $draft->soft_id = $softId;
        $draft->isDefault = true;

        return $draft;
    }

    /**
     * 同じゲームで下書きがあるパッケージIDのハッシュを取得
     *
     * @param int $userId
     * @param int $softId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getHashBySoft($userId, $softId)
    {
        return self::where('user_id', $userId)
            ->where('soft_id', $softId)
            ->get()
            ->pluck('package_id', 'package_id');
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

    public function getGoodTags()
    {
        if ($this->isDefault) {
            return [1,2];
        }
        $this->setTags();

        return $this->goodTags;
    }

    public function getVeryGoodTags()
    {
        if ($this->isDefault) {
            return [];
        }
        $this->setTags();

        return $this->veryGoodTags;
    }

    public function getBadTags()
    {
        if ($this->isDefault) {
            return [];
        }
        $this->setTags();

        return $this->badTags;
    }

    public function getVeryBadTags()
    {
        if ($this->isDefault) {
            return [];
        }

        $this->setTags();

        return $this->veryBadTags;
    }

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
                    $this->veryGoodTags[] = $tag->tag;
                    break;
                case -1:
                    $this->baTags[] = $tag->tag;
                    break;
                case -2:
                    $this->veryBadTags[] = $tag->tag;
                    break;
            }
        }
    }
}
