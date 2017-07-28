<?php
/**
 * 検索
 */

namespace Hgs3\Models\Site;

use Hgs3\User;
use Illuminate\Support\Facades\DB;

class Searcher
{
    /**
     * 検索
     *
     * @param $gameId
     * @param $mainContents
     * @param $targetGender
     * @param $rate
     * @param $pagePerNum
     * @return array
     */
    public function search($gameId, $mainContents, $targetGender, $rate, $pagePerNum)
    {
        $data = [];

        // 検索テーブルからIDを取得
        $data['pager'] = DB::table('site_search_indices')
            ->select('site_id')
            ->where('game_id', '=', $gameId)
            //->where('main_contents_id', '=', $mainContents)
            //->where('gender', '=', $targetGender)
            //->where('rate', '=', $rate)
            ->orderBy('updated_timestamp', 'DESC')
            ->paginate($pagePerNum);

        $data['sites'] = [];
        if (!empty($data['pager'])) {
            $siteIds = array_pluck($data['pager']->items(), 'site_id');
            $sites = DB::table('sites')
                ->whereIn('id', $siteIds)
                ->get();

            // 連想配列化しとく
            foreach ($sites as $s) {
                $data['sites'][$s->id] = $s;
            }

            $data['users'] = User::getNameHash(array_pluck($data['sites'], 'user_id'));
        }

        return $data;
    }
}