<?php
/**
 * ORM: games
 */

namespace Hgs3\Models\Orm;
use Hgs3\Constants\PhoneticType;
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

    /**
     * データをハッシュで取得
     *
     * @param array $ids
     * @return mixed
     */
    public static function getHash(array $ids = [])
    {
        if (empty($ids)) {
            $data = self::get();
        } else {
            $data = self::whereIn('id', $ids)
                ->get();
        }

        $result = [];
        foreach ($data as $row) {
            $result[$row->id] = $row;
        }

        unset($data);
        return $result;
    }

    /**
     * 表示順を更新
     */
    public static function updateSortOrder()
    {
        // SQL文1発でできそうだけど、複雑になるのでループ回して1つずつ更新

        $sql =<<< SQL
SELECT soft.id, IF(soft.series_id IS NULL, soft.phonetic, series.phonetic) AS phonetic_order
FROM game_softs AS soft LEFT OUTER JOIN game_series AS series ON 
  soft.series_id = series.id
ORDER BY phonetic_order, soft.order_in_series
SQL;

        $data = DB::select($sql);
        $n = count($data);

        $update =<<< SQL
UPDATE game_softs SET phonetic_order = ?
WHERE id = ?
SQL;

        for ($i = 1; $i <= $n; $i++) {
            DB::update($update, [$i, $data[$i - 1]->id]);
        }
    }

    /**
     * 保存
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $this->phonetic_type = PhoneticType::getTypeByPhonetic($this->phonetic);

        return parent::save();
    }
}
