<?php
/**
 * ゲームソフトモデル
 */

namespace Hgs3\Models\Game;

use Hgs3\Models\Orm;
use Hgs3\Models\Timeline;
use Hgs3\Models\User\FavoriteSoft;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Soft
{
    /**
     * 一覧用データ取得
     *
     * @return array
     */
    public function getList()
    {
        $tmp = DB::table('game_softs')
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

    /**
     * 詳細データ取得
     *
     * @param Orm\GameSoft $soft
     * @return array
     */
    public static function getDetail(Orm\GameSoft $soft)
    {
        $data = ['soft' => $soft];

        // 同じシリーズのソフト取得
        if ($soft->series_id != null) {
            $data['series'] = Orm\GameSeries::find($soft->series_id);
            if ($data['series']) {
                $data['seriesSofts'] = self::getSameSeries($soft->id, $soft->series_id);
            }
        } else {
            $data['series'] = null;
        }

        // パッケージ情報
        $data['packages'] = self::getPackages($soft->id);
        $data['packageNum'] = count($data['packages']);

        // レビュー
        $data['reviewTotal'] = Orm\ReviewTotal::find($soft->id);

        // お気に入り登録ユーザー
        $data['favorite'] = self::getFavoriteUser($soft->id);
        $data['favoriteNum'] = Orm\UserFavoriteSoft::where('soft_id', $soft->id)->count(['user_id']);

        // サイト
        $data['site'] = self::getSite($soft->id);
        $data['siteNum'] = Orm\SiteSearchIndex::where('soft_id', $soft->id)->count(['site_id']);

        // 遊んだゲーム
        $data['playedUsers'] = self::getPlayedUsers($soft->id);

        if (Auth::check()) {
            $fav = new FavoriteSoft();
            $data['isFavorite'] = $fav->isFavorite(Auth::id(), $soft->id);
            $data['playedGame'] = Orm\UserPlayedSoft::findByUserAndGame(Auth::id(), $soft->id);
        }

        return $data;
    }

    /**
     * 同一シリーズのソフトを取得
     *
     * @param int $softId
     * @param int $seriesId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    private static function getSameSeries($softId, $seriesId)
    {
        $sql =<<< SQL
SELECT soft.id, soft.name, package.small_image_url AS image_url
FROM
  (
    SELECT id, `name`, original_package_id
    FROM game_softs
    WHERE series_id = ?
      AND id <> ?
  ) soft
  LEFT OUTER JOIN game_packages package ON package.id = soft.original_package_id
SQL;

        return DB::select($sql, [$seriesId, $softId]);
    }

    /**
     * パッケージの一覧を取得
     *
     * @param int $softId
     * @return array
     */
    private static function getPackages($softId)
    {
        $packageIds = DB::table('game_package_links')
            ->select(['package_id'])
            ->where('soft_id', $softId)
            ->get()
            ->pluck('package_id')
            ->toArray();

        if (empty($packageIds)) {
            return [];
        }

        $packageIdsComma = implode(',', $packageIds);

        $sql =<<< SQL
SELECT pkg.*, plt.acronym AS platform_name, com.name AS company_name
FROM (
  SELECT id, `name`, platform_id, release_at, company_id, medium_image_url
  FROM game_packages
  WHERE id IN ({$packageIdsComma})
) pkg
  LEFT OUTER JOIN game_platforms plt ON pkg.platform_id = plt.id
  LEFT OUTER JOIN game_companies com ON pkg.company_id = com.id
SQL;

        $data = DB::select($sql);

        $shops = Package::getShopData($packageIds);

        $n = count($data);
        for ($i = 0; $i < $n; $i++) {
            $data[$i]->shops = $shops[$data[$i]->id] ?? [];
        }

        unset($shops);

        return $data;
    }

    /**
     * お気に入りゲーム登録ユーザーを取得
     *
     * @param int $softId
     * @return array
     */
    private static function getFavoriteUser($softId)
    {
        $sql =<<< SQL
SELECT users.id, users.name, users.icon_upload_flag
FROM (
  SELECT user_id FROM user_favorite_softs WHERE soft_id = ? ORDER BY id LIMIT 5
) fav LEFT OUTER JOIN users ON fav.user_id = users.id
SQL;

        return DB::select($sql, [$softId]);
    }

    /**
     * サイト情報を取得
     *
     * @param int $softId
     * @return array
     */
    private static function getSite($softId)
    {
        $siteIds = DB::table('site_search_indices')
            ->select(['site_id'])
            ->where('soft_id', $softId)
            ->orderBy('updated_timestamp', 'DESC')
            ->take(5)->get()->pluck('site_id')->toArray();

        if (empty($siteIds)) {
            return [];
        }

        $siteIdComma = implode(',', $siteIds);

        $sql =<<< SQL
SELECT users.id user_id, users.name user_name, users.show_id, s.id, s.name, s.url, s.presentation, s.rate,
  s.gender, s.main_contents_id, s.out_count, s.in_count, s.good_num
FROM (
  SELECT * FROM sites WHERE id IN ({$siteIdComma})
) s LEFT OUTER JOIN users ON s.user_id = users.id
SQL;

        return DB::select($sql, [$softId]);
    }

    /**
     * 遊んだプレーヤーを取得
     *
     * @param int $softId
     * @return array
     */
    private static function getPlayedUsers($softId)
    {
        $sql =<<< SQL
SELECT users.id, users.name
FROM (
  SELECT user_id FROM user_played_softs WHERE soft_id = ? ORDER BY id LIMIT 5
) fav LEFT OUTER JOIN users ON fav.user_id = users.id
SQL;

        return DB::select($sql, [$softId]);
    }

    /**
     * 保存
     *
     * @param Orm\GameSoft $soft
     * @param bool $isWriteTimeine
     * @return bool
     */
    public static  function save(Orm\GameSoft $soft, $isWriteTimeine)
    {
        $isNew = $soft->id === null;

        DB::beginTransaction();
        try {
            $soft->save();

            $soft::updateSortOrder();

            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        // タイムライン登録しない
        if (!$isWriteTimeine) {
            return true;
        }

        if ($isNew) {
            //Timeline\Game::addNewGameSoftText($this->id, $this->name);

            // TODO 新着情報に登録

            // 同じシリーズの別ゲームが追加された
            if ($soft->series_id !== null) {
                $series = Orm\GameSeries::find($soft->series_id);
                if ($series) {
                    //Timeline\FavoriteSoft::addSameSeriesGameText($soft, $series);
                }
            }
        } else {
            //Timeline\FavoriteSoft::addUpdateGameSoftText($soft);
        }
        return true;
    }
}