<?php
/**
 * ゲーム追加要望モデル
 */

namespace Hgs3\Models\Game;

use Hgs3\Models\Orm\GameRequestComment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameRequest
{
    /**
     * コメントの書き込み
     *
     * @param \Hgs3\Models\Orm\GameRequest $req
     * @param $userId
     * @param $comment
     * @return bool
     */
    public function writeComment(\Hgs3\Models\Orm\GameRequest $req, $userId, $comment)
    {
        DB::beginTransaction();

        try {
            $grc = new GameRequestComment;
            $grc->game_request_id = $req->id;
            $grc->user_id = $userId;
            $grc->comment = $comment;

            $grc->save();

            $req->comment_num++;
            $req->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return true;
    }

    /**
     * コメントの削除
     *
     * @param GameRequest $req
     * @param GameRequestComment $grc
     * @return bool
     */
    public function deleteComment(\Hgs3\Models\Orm\GameRequest $req, GameRequestComment $grc)
    {
        DB::beginTransaction();

        try {
            $grc->delete();

            $req->comment_num--;
            $req->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return true;
    }

    /**
     * コメントを取得
     *
     * @param int $reqId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getComment($reqId)
    {
        return GameRequestComment::where('game_request_id', $reqId)
            ->orderBy('id', 'DESC')
            ->paginate(20);
    }
}