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
            ->pluck('id')
            ->toArray();
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

    /**
     * パッケージを取得
     *
     * @param $softId
     * @return array
     */
    public static function getPackageIds($softId)
    {
        return DB::table('game_package_links')
            ->select(['package_id'])
            ->where('soft_id', $softId)
            ->get()
            ->pluck('package_id')
            ->toArray();
    }
}