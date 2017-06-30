<?php

namespace Hgs3\Models\Game;

use Hgs3\Models\Orm\GameCompany;
use Hgs3\Models\Orm\GamePackage;
use Hgs3\Models\Orm\SiteSearchIndex;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\GameSeries;

class Searcher
{
    public function search($gameId, $mainContents, $targetGender, $rate, $pagePerNum)
    {
        $data = array();

        // 検索テーブルからIDを取得
        $data['pager'] = DB::table('site_search_indices')
            ->select('site_id')
            ->where('game_id', '=', $gameId)
            ->where('main_contents', '=', $mainContents)
            ->where('target_gender', '=', $targetGender)
            ->where('rate', '=', $rate)
            ->orderBy('updated_timestamp', 'DESC')
            ->paginate($pagePerNum);

        $data['sites'] = [];
        if (!empty($data['pager'])) {
            $siteIds = Arr::pluck($data['pager'], 'site_id');
            $sites = DB::table('sites')
                ->whereIn('id', $siteIds)
                ->get();

            // 連想配列化しとく
            foreach ($sites as $s) {
                $data['sites'][$s->id] = $s;
            }
        }

        return $data;
    }
}