<?php
/**
 * ORM: games
 */

namespace Hgs3\Models\Orm;
use Hgs3\Models\Timeline;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Game extends \Eloquent
{
    /**
     * ゲームソフト名のハッシュを取得
     *
     * @param array $ids
     * @return mixed
     */
    public static function getNameHash(array $ids = array())
    {
        $tbl = DB::table('games');

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
     * 保存
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $isNew = $this->id === null;

        DB::beginTransaction();
        try {
            parent::save($options);

            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        if ($isNew) {
            //Timeline\Game::addNewGameSoftText($this->id, $this->name);

            // TODO 新着情報に登録

            if ($this->series_id !== null) {
                Timeline\Game::addSameSeriesGameText($this->id, $this->name, $this->series_id, null);
            }
        } else {
            Timeline\Game::addUpdateGameSoftText($this->id, $this->name);
        }
        return true;
    }
}
