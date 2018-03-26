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
            'fear'            => 5,
            'story'           => 3,
            'volume'          => 3,
            'difficulty'      => 3,
            'graphic'         => 3,
            'sound'           => 3,
            'crowded'         => 3,
            'controllability' => 3,
            'recommend'       => 3,
            'progress'        => '',
            'text'            => '',
            'is_spoiler'      => 0
        ]);

        $draft->user_id = $userId;
        $draft->soft_id = $softId;

        return $draft;
    }

    /**
     * ポイントの計算
     */
    public function calcPoint()
    {
        $this->point = 0;
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
     * @return Model|null|static
     */
    public static function getData($userId, $softId)
    {
        return ReviewDraft::where('soft_id', $softId)
            ->where('user_id', $userId)
            ->first();
    }
}
