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
    protected $guarded = ['id'];

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

        $data = DB::table('sites')
            ->whereIn('id', $siteIds)
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
            ->select(['id', 'name'])
            ->whereIn('id', $siteIds)
            ->get();

        $hash = [];
        foreach ($data as $site) {
            $hash[$site->id] = $site->name;
        }

        unset($data);

        return $hash;
    }

    /**
     * 特定ユーザーが持っているサイト数を取得
     *
     * @param $userId
     * @return int
     */
    public static function getNumByUser($userId)
    {
        return self::where('user_id', $userId)
            ->count('id');
    }

    /**
     * お気に入り数を取得
     *
     * @return int
     */
    public function getFavoriteNum()
    {
        return UserFavoriteSite::where('site_id', $this->id)
            ->count('site_id');
    }
}
