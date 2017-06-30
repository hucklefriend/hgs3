<?php

namespace Hgs3\Models\Game;

use Hgs3\Models\Orm\GameCompany;
use Hgs3\Models\Orm\GamePackage;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\GameSeries;

class Soft
{
    public function getList()
    {
        $tmp = DB::table('games')
            ->select('id', 'name', 'phonetic_type')
            ->orderBy('phonetic_type', 'asc')
            ->orderBy('phonetic_order', 'asc')
            ->get();

        $result = array();
        foreach ($tmp as $game) {
            $result[$game->phonetic_type][] = $game;
        }

        return $result;
    }

    public function getDetail(Game $game)
    {
        $data = $game->toArray();

        // シリーズ
        if ($game->series_id != null) {
            $data['series'] = $this->getDetailSeries($game->id, $game->series_id);
        } else {
            $data['series'] = null;
        }

        // メーカー
        if ($game->company_id != null) {
            $data['company'] = GameCompany::find($game->company_id);
        } else {
            $data['company'] = null;
        }

        // パッケージ情報
        $data['packages'] = $this->getDetailPackages($game->id);

        return $data;
    }

    private function getDetailSeries($gameId, $seriesId)
    {
        $series = GameSeries::find($seriesId);

        $data = array(
            'name' => $series->name
        );

        $data['list'] = DB::table('games')
            ->where('series_id', $seriesId)
            ->where('id', '<>', $gameId)
            ->get();

        return $data;
    }

    private function getDetailPackages($gameId)
    {
        $sql =<<< SQL
SELECT pkg.*, plt.id plt_id, plt.name AS platform_name
FROM (
  SELECT * FROM game_packages WHERE game_id = ?
) pkg
  LEFT OUTER JOIN game_platforms plt ON pkg.platform_id = plt.id
SQL;

        return DB::select($sql, [$gameId]);
    }

    public static function getNameHash(array $ids = array())
    {
        $tbl = DB::table('games');

        if (!empty($ids)) {
            $tbl->whereIn('id', $ids);
        }

        return $tbl->get()->pluck('name', 'id')->toArray();
    }
}