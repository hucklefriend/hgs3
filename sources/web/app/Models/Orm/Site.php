<?php
/**
 * ORM: sites
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Site extends \Eloquent
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

    /**
     * ハッシュでデータを取得
     *
     * @param array $siteIds
     * @return array
     */
    public static function getHash(array $siteIds)
    {
        if (empty($siteIds)) {
            return [];
        }

        $data = DB::table('user_favorite_sites')
            ->whereIn('site_id', $siteIds)
            ->get();

        $hash = [];
        foreach ($data as $site) {
            $hash[$site->id] = $site;
        }

        unset($data);

        return $hash;
    }

    /**
     * ハッシュでデータを取得
     *
     * @param array $siteIds
     * @return array
     */
    public static function getNameHash(array $siteIds)
    {
        if (empty($siteIds)) {
            return [];
        }

        $data = DB::table('sites')
            ->whereIn('id', $siteIds)
            ->get();

        $hash = [];
        foreach ($data as $site) {
            $hash[$site->id] = $site->name;
        }

        unset($data);

        return $hash;
    }
}
