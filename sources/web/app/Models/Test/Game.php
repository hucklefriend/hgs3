<?php
/**
 * ユーザーのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\UserFollow;

class Game
{
    /**
     * ゲームIDの配列を取得
     *
     * @return array
     */
    public static function getIds()
    {
        return DB::table('games')
            ->select('id')
            ->get()
            ->pluck('id');
    }
}