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
            ->select('id')
            ->get();
    }

    /**
     * リンクのハッシュを取得
     *
     * @return static
     */
    public static function getLinkHash()
    {
        return DB::table('game_package_links')
            ->select(['soft_id', 'package_id'])
            ->get()
            ->pluck('soft_id', 'package_id')
            ->toArray();
    }
}