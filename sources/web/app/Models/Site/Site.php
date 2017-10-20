<?php
/**
 * サイトモデル
 */

namespace Hgs3\Models\Site;

use Hgs3\Models\Orm;
use Hgs3\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Hgs3\Models\Timeline;

class Site
{
    /**
     * 登録
     *
     * @param User $user
     * @param Orm\Site $orm
     * @param string $handleGamesComma
     */
    public function save(User $user, Orm\Site $orm, $handleGamesComma)
    {
        $isAdd = $orm->id === null;

        $handleGameIds = explode(',', $handleGamesComma);

        if (!$isAdd) {
            // タイムライン用に現在の取扱いゲームを取得
            $prevHandleGameIds = DB::table('site_handle_games')
                ->select(['game_id'])
                ->where('site_id', $orm->id)
                ->get()
                ->pluck('game_id', 'game_id')
                ->toArray();
        }

        DB::beginTransaction();
        try {
            $orm->save();

            $this->saveHandleGame($orm->user_id, $handleGameIds);

            $this->saveSearchIndex($orm, $handleGameIds);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        // タイムライン
        if ($isAdd) {
            Timeline\User::addAddSiteText($user->id, $user->name, $orm->id, $orm->name);

            // TODO ループを回さずに、配列を渡して内部で一括登録するようにしたい
            foreach ($handleGameIds as $gameId) {
                Timeline\FavoriteGame::addNewSiteText($gameId, null, $orm->id, $orm->name);
            }
        } else {
            Timeline\User::addUpdateSiteText($user->id, $user->name, $orm->id, $orm->name);

            // 直前に取りつかってないゲームを追加
            foreach ($handleGameIds as $gameId) {
                if (!isset($prevHandleGameIds[$gameId])) {
                    Timeline\FavoriteGame::addNewSiteText($gameId, null, $orm->id, $orm->name);
                }
            }
        }

        return true;
    }

    /**
     * 取扱いゲームを保存
     *
     * @param int $siteId
     * @param string $handleGameIds
     */
    private function saveHandleGame($siteId, array $handleGameIds)
    {
        DB::table('site_handle_games')
            ->where('site_id', $siteId)
            ->delete();

        if (!empty($handleGameIds)) {
            $data = [];
            foreach ($handleGameIds as $gameId) {
                if (!empty($gameId)) {
                    $data[] = [
                            'site_id' => $siteId,
                            'game_id' => $gameId
                        ];
                }
            }

            DB::table('site_handle_games')
                ->insert($data);
        }
    }

    /**
     * 検索インデックステーブルに保存
     *
     * @param Orm\Site $orm
     * @param array $handleGames
     */
    private function saveSearchIndex(Orm\Site $orm, array $handleGames)
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

    /**
     * ユーザーのサイトを取得
     *
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get($userId)
    {
        return \Hgs3\Models\Orm\Site::where('user_id', $userId)
            ->orderBy( 'id')
            ->get();
    }
}