<?php
/**
 * ユーザーのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\UserFollow;

class Package
{
    /**
     * パッケージの配列を取得
     *
     * @return array
     */
    public static function get()
    {
        return DB::table('game_packages')
            ->select('id', 'soft_id')
            ->get();
    }
}