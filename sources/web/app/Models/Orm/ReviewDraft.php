<?php
/**
 * ORM: review_drafts
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReviewDraft extends Model
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
/*
    public function insert()
    {
        return DB::table($this->getTable())
            ->insert([
                'user_id'         => $this->user_id,
                'game_id'         => $this->game_id,
                'package_id'      => $this->package_id,
                'play_time'       => $this->play_time,
                'title'           => $this->title,
                'fear'            => $this->fear,
                'story'           => $this->story,
                'volume'          => $this->volume,
                'difficulty'      => $this->difficulty,
                'graphic'         => $this->graphic,
                'sound'           => $this->sound,
                'crowded'         => $this->crowded,
                'controllability' => $this->controllability,
                'recommend'       => $this->recommend,
                'thoughts'        => $this->thoughts,
                'recommendatory'  => $this->recommendatory,
            ]);
    }

    public function update(array $attributes = [], array $options = [])
    {
        return DB::table($this->getTable())
            ->where('user_id', $this->user_id)
            ->where('game_id', $this->game_id)
            ->update([
                'package_id'      => $this->package_id,
                'play_time'       => $this->play_time,
                'title'           => $this->title,
                'fear'            => $this->fear,
                'story'           => $this->story,
                'volume'          => $this->volume,
                'difficulty'      => $this->difficulty,
                'graphic'         => $this->graphic,
                'sound'           => $this->sound,
                'crowded'         => $this->crowded,
                'controllability' => $this->controllability,
                'recommend'       => $this->recommend,
                'thoughts'        => $this->thoughts,
                'recommendatory'  => $this->recommendatory,
            ]);
    }
*/
}
