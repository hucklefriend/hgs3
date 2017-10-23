<?php
/**
 * ゲームソフトモデル
 */

namespace Hgs3\Models\Game;

use Hgs3\Models\Orm;
use Hgs3\Models\Timeline;
use Hgs3\Models\User\FavoriteGame;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Package
{
    /**
     * パッケージのショップデータを取得
     *
     * @param array $packageIds
     * @return array
     */
    public static function getShopData(array $packageIds)
    {
        $data = DB::table('game_package_shops')
            ->select(['shop_id', 'shop_url'])
            ->where('package_id', 'in', $packageIds)
            ->get();

        $hash = [];
        foreach ($data as $row) {
            $hash[intval($row->package_id)][] = $row;
        }

        unset($data);

        return $hash;
    }
}