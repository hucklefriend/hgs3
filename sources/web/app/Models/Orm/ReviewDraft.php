<?php
/**
 * ORM: review_drafts
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReviewDraft extends \Eloquent
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $guarded = ['user_id'];

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
            'play_time'       => 0,
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
            'thoughts'        => '',
            'recommendatory'  => '',
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
}
