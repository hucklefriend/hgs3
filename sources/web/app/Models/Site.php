<?php
/**
 * サイトモデル
 */

namespace Hgs3\Models;

use Hgs3\Models\Orm\SiteSearchIndex;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Site
{
    /**
     * 登録
     *
     * @param int $userId
     * @param Orm\Site $orm
     * @param string $handleGamesComma
     */
    public function add($userId, \Hgs3\Models\Orm\Site $orm, $handleGamesComma)
    {
        DB::beginTransaction();
        try {
            $orm->save();

            $handleGameIds = explode(',', $handleGamesComma);
            $this->saveHandleGame($userId, $handleGameIds);

            $this->saveSearchIndex($orm, $handleGameIds);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            echo $e->getMessage();

            return false;
        }

        return true;
    }

    public function update()
    {

    }

    /**
     * 取扱いゲームと共に保存
     *
     * @param int $siteId
     * @param string $handleGameIds
     */
    private function saveHandleGame($siteId, array $handleGameIds)
    {
        $sql =<<< SQL
DELETE FROM site_handle_games WHERE site_id = ?
SQL;
        DB::delete($sql, [$siteId]);

        if (!empty($handleGameIds)) {
            foreach ($handleGameIds as $gameId) {
                if (!empty($gameId)) {
                    DB::table('site_handle_games')
                        ->insert([
                            'site_id' => $siteId,
                            'game_id' => $gameId
                        ]);
                }
            }
        }
    }

    /**
     * 検索インデックステーブルに保存
     *
     * @param Orm\Site $orm
     * @param array $handleGames
     */
    private function saveSearchIndex(\Hgs3\Models\Orm\Site $orm, array $handleGames)
    {
        // 先に消す
        DB::table('site_search_indices')
            ->where('site_id', $orm->id)
            ->delete();

        // 登録
        $sql =<<< SQL
INSERT IGNORE INTO site_search_indices (site_id, game_id, main_contents_id, gender, rate, updated_timestamp, created_at, updated_at)
VALUES (?, ?, ?, ?, ?, UNIX_TIMESTAMP(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
SQL;

        foreach ($handleGames as $gameId) {
            DB::insert($sql, [$orm->id, $gameId, $orm->main_contents_id, $orm->gender, $orm->rate]);
        }
    }


    public function getNewcomer()
    {
        return DB::table('sites')
            ->orderBy('registered_timestamp', 'DESC')
            ->take(5)
            ->get();
    }

    public function getLatestUpdate()
    {
        return DB::table('sites')
            ->orderBy('updated_timestamp', 'DESC')
            ->take(5)
            ->get();
    }

    public function getAccessRanking()
    {
        return DB::table('sites')
            ->orderBy('out_count', 'DESC')
            ->take(5)
            ->get();
    }

    public function getGoodRanking()
    {
        return DB::table('sites')
            ->orderBy('good_count', 'DESC')
            ->take(5)
            ->get();
    }
}