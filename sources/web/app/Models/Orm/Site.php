<?php
/**
 * ORM: sites
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Site extends Model
{
    /**
     * 取扱いゲームのIDを取得
     *
     * @return \Illuminate\Support\Collection
     */
    public function getHandleGames()
    {
        return SiteHandleGame::where('site_id', $this->id)
            ->get()
            ->pluck('game_id')
            ->toArray();
    }

    /**
     * 取扱いゲームのテキストを取得
     *
     * @return string
     */
    public function getHandleGameText()
    {
        $handleGames = $this->getHandleGames();
        if (empty($handleGames)) {
            return '';
        } else {
            return implode('、', $handleGames);
        }
    }

    /**
     * 取扱いゲームと共に保存
     *
     * @param $handleGamesComma
     */
    public function saveWithHandleGame($handleGamesComma)
    {
        DB::beginTransaction();
        try {
            $this->save();

            $sql =<<< SQL
DELETE FROM site_handle_games WHERE site_id = ?
SQL;
            DB::delete($sql, [$this->id]);

            $handleGameIds = explode(',', $handleGamesComma);
            if (!empty($handleGameIds)) {
                foreach ($handleGameIds as $gameId) {
                    if (!empty($gameId)) {
                        DB::table('site_handle_games')
                            ->insert([
                                'site_id' => $this->id,
                                'game_id' => $gameId
                            ]);
                    }
                }
            }

            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return $this->id;
    }

    public function getNearlyFootprint()
    {

    }
}
