<?php
/**
 * ゲーム追加リクエストのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;

class GameRequestComment
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        $reqIds = GameRequest::getIds();

        $userIds = User::getIds();
        $userMax = count($userIds) - 1;

        $model = new \Hgs3\Models\Game\GameRequest();

        foreach ($reqIds as $reqId) {
            $num = rand(1, 100);

            for ($i = 0; $i < $num; $i++) {
                $model->writeComment(
                    \Hgs3\Models\Orm\GameRequest::find($reqId),
                    $userIds[rand(0, $userMax)],
                    str_random(10)
                );
            }
        }
    }

    /**
     * IDの配列を取得
     *
     * @return array
     */
    public static function getIds()
    {
        return DB::table('game_request_comments')
            ->select('id')
            ->get()
            ->pluck('id');
    }
}