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

    public function getNearlyFootprint()
    {

    }
}
