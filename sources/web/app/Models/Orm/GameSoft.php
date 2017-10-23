<?php
/**
 * ORM: games
 */

namespace Hgs3\Models\Orm;
use Hgs3\Models\Timeline;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameSoft extends \Eloquent
{
    /**
     * ゲームソフト名のハッシュを取得
     *
     * @param array $ids
     * @return mixed
     */
    public static function getNameHash(array $ids = array())
    {
        $tbl = DB::table('game_softs')
            ->select(['id', 'name']);

        if (!empty($ids)) {
            $tbl->whereIn('id', $ids);
        }

        return $tbl->get()->pluck('name', 'id')->toArray();
    }

    /**
     * よみがた単位でハッシュを取得
     *
     * @param array $ids
     * @return mixed
     */
    public static function getPhoneticTypeHash()
    {
        $data = self::select(['id', 'name', 'phonetic_type'])
            ->orderBy('phonetic_order')
            ->get();

        $result = [];

        foreach ($data as $game) {
            $result[intval($game->phonetic_type)][] = $game;
        }
        unset($data);

        return $result;
    }
}
