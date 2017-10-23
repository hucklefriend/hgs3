<?php
/**
 * ゲームソフトのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm;

class GameSoft
{
    /**
     * ゲームソフトIDの配列を取得
     *
     * @return array
     */
    public static function getIds()
    {
        return DB::table('game_softs')
            ->select(['id'])
            ->get()
            ->pluck('id');
    }

    /**
     * データを取得
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function get()
    {
        return Orm\GameSoft::all();
    }
}