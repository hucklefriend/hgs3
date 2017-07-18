<?php
/**
 * レビューモデル
 */


namespace Hgs3\Models\Game;

use Hgs3\Models\Orm\ReviewDraft;
use Illuminate\Support\Facades\DB;

class Review
{
    /**
     * 新着順レビューを取得
     *
     * @param $gameId
     * @param $num
     */
    public function getNewArrivals($gameId, $num)
    {
        $sql =<<< SQL
SELECT
  reviews.*
  , users.name
FROM (
    SELECT id, point, user_id
    FROM reviews
    WHERE game_id = ?
    ORDER BY id DESC
    LIMIT {$num}
  ) reviews LEFT OUTER JOIN users ON reviews.user_id = users.id
SQL;

        return DB::select($sql, [$gameId]);
    }

    /**
     * 下書きを取得
     *
     * @param $userId
     * @param $gameId
     */
    public function getDraft($userId, $gameId)
    {
        if ($userId == null) {
            return ReviewDraft::getDefault($userId, $gameId);
        }

        $draft = ReviewDraft::where('user_id', $userId)
            ->where('game_id', $gameId)
            ->first();

        return $draft ?? ReviewDraft::getDefault($userId, $gameId);
    }
}