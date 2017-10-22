<?php
/**
 * ORM: review_drafts
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReviewDraft extends \Eloquent
{
    protected $primaryKey = ['user_id', 'package_id'];
    public $incrementing = false;
    protected $guarded = ['user_id', 'package_id'];

    /**
     * デフォルト値が設定されているインスタンスを取得
     *
     * @param $userId
     * @param $gameId
     * @return ReviewDraft
     */
    public static function getDefault($userId, $gameId)
    {
        return new self([
            'user_id'         => $userId,
            'game_id'         => $gameId,
            'package_id'      => '',
            'title'           => '',
            'fear'            => 3,
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
    }

    /**
     * ポイントの計算
     */
    public function calcPoint()
    {
        $this->point =
            $this->fear * 4 + ($this->story + $this->volume + $this->difficulty +
                $this->graphic + $this->sound + $this->crowded + $this->controllability + $this->recommend) * 2;
    }

    /**
     * 同じゲームで下書きがあるパッケージIDのハッシュを取得
     *
     * @param $userId
     * @param $gameId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getHashByGame($userId, $gameId)
    {
        return self::where('user_id', $userId)
            ->where('game_id', $gameId)
            ->get()
            ->pluck('package_id', 'package_id');
    }

    /**
     * データを取得
     *
     * @param int $userId
     * @param int $packageId
     * @return Model|null|static
     */
    public static function getData($userId, $packageId)
    {
        return ReviewDraft::where('user_id', $userId)
            ->where('package_id', $packageId)
            ->first();
    }
}
