<?php
/**
 * ORM: review_totals
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReviewTotal extends \Eloquent
{
    protected $primaryKey = 'game_id';
    public $incrementing = false;
    protected $guarded = ['game_id'];

    /**
     * 集計
     *
     * @param $gameId
     */
    public static function calculate($gameId)
    {
        $sql =<<< SQL
INSERT INTO review_totals
(game_id, review_num, play_time, point, fear, story, volume, difficulty, graphic, sound, crowded, controllability, recommend)
SELECT
  {$gameId}
  , COUNT(id)
  , IFNULL(AVG(play_time), 0)
  , IFNULL(AVG(point), 0)
  , IFNULL(AVG(fear), 0)
  , IFNULL(AVG(story), 0)
  , IFNULL(AVG(volume), 0)
  , IFNULL(AVG(difficulty), 0)
  , IFNULL(AVG(graphic), 0)
  , IFNULL(AVG(sound), 0)
  , IFNULL(AVG(crowded), 0)
  , IFNULL(AVG(controllability), 0)
  , IFNULL(AVG(recommend), 0)
FROM
  reviews
WHERE
  game_id = ?
ON DUPLICATE KEY UPDATE
  review_num = VALUES(review_num)
  , play_time = VALUES(play_time)
  , point = VALUES(point)
  , fear = VALUES(fear)
  , story = VALUES(story)
  , volume = VALUES(volume)
  , difficulty = VALUES(difficulty)
  , graphic = VALUES(graphic)
  , sound = VALUES(sound)
  , crowded = VALUES(crowded)
  , controllability = VALUES(controllability)
  , recommend = VALUES(recommend)
  , updated_at = CURRENT_TIMESTAMP
SQL;

        DB::insert($sql, [$gameId]);
    }
}
