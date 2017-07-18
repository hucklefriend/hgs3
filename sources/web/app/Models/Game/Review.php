<?php
/**
 * レビューモデル
 */


namespace Hgs3\Models\Game;

use Hgs3\Http\Requests\Game\Review\InputRequest;
use Hgs3\Models\Orm\ReviewDraft;
use Hgs3\Models\Orm\ReviewTotal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function save(InputRequest $request)
    {
        $orm = new \Hgs3\Models\Orm\Review;

        $orm->user_id = \Auth::id();
        $orm->game_id = $request->get('game_id');
        $orm->package_id = '';
        $orm->play_time = $request->get('play_time') ?? 0;
        $orm->title = $request->get('title') ?? '';
        $orm->fear = $request->get('fear') ?? 0;
        $orm->story = $request->get('story') ?? 0;
        $orm->volume = $request->get('volume') ?? 0;
        $orm->difficulty = $request->get('difficulty') ?? 0;
        $orm->graphic = $request->get('graphic') ?? 0;
        $orm->sound = $request->get('sound') ?? 0;
        $orm->crowded = $request->get('crowded') ?? 0;
        $orm->controllability = $request->get('controllability') ?? 0;
        $orm->recommend = $request->get('recommend') ?? 0;
        $orm->thoughts = $request->get('thoughts') ?? '';
        $orm->recommendatory = $request->get('recommendatory') ?? '';

        DB::beginTransaction();
        try {
            // 保存
            $orm->save();

            // 統計
            ReviewTotal::calculate($orm->game_id);

            DB::table('review_drafts')
                ->where('user_id', $orm->user_id)
                ->where('game_id', $orm->game_id)
                ->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return $orm->id;
    }
}