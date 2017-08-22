<?php
/**
 * ゲーム追加リクエストのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;

class GameRequest
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        $userIds = User::getIds();
        $userMax = count($userIds) - 1;

        for ($i = 0; $i < 100; $i++) {
            $r = new \Hgs3\Models\Orm\GameRequest;

            $r->user_id = $userIds[rand(0, $userMax)];
            $r->name = str_random(10);

            $r->save();
        }
    }

    /**
     * IDを取得
     *
     * @return array
     */
    public static function getIds()
    {
        return DB::table('game_requests')
            ->select('id')
            ->get()
            ->pluck('id');
    }
}