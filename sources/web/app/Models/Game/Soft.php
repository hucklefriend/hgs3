<?php
/**
 * ゲームソフトモデル
 */

namespace Hgs3\Models\Game;

use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Hgs3\Models\User\FavoriteSoft;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Soft
{
    /**
     * 一覧用データ取得
     *
     * @param array $favoriteHash
     * @param bool $isGuest
     * @return array
     */
    public static function getList(array $favoriteHash, $isGuest)
    {
        $appendQuery = '';
        if ($isGuest) {
            $appendQuery = 'WHERE adult_only_flag = 0' . PHP_EOL;
        }

        $sql = <<< SQL
SELECT
  s.id
  , s.name
  , s.phonetic_type
  , p.small_image_url
  , p.medium_image_url
  , p.is_adult
FROM
  game_softs s
  LEFT OUTER JOIN game_packages p ON s.original_package_id = p.id
{$appendQuery}
ORDER BY
  phonetic_type
  , phonetic_order
SQL;

        $tmp = DB::select($sql);

        $result = array();
        $favorite = [];
        foreach ($tmp as $game) {
            $result[$game->phonetic_type][] = $game;

            if (isset($favoriteHash[$game->id])) {
                $favorite[] = $game;
            }
        }

        $result[100] = $favorite;

        unset($tmp);

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
        if (!(Auth::check() && Auth::user()->isAdult())) {
            if ($soft->introduction_from_adult == 1) {
                $soft->introduction_from = trim(strip_tags($soft->introduction_from));
            }
        }

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
        $data['originalPackage'] = $soft->originalPackage();
        if ($data['originalPackage'] != null) {
            $data['hasOriginalPackageImage'] = !empty(medium_image_url($data['originalPackage']));
        } else {
            $data['hasOriginalPackageImage'] = false;
        }


        // 発売日を過ぎているか
        $today = date('Ymd');
        $data['released'] = $soft->first_release_int <= $today;
        $canAdult = Auth::check() && Auth::user()->isAdult();
        $sampleImagePackages = [];
        foreach ($data['packages'] as $pkg) {
            if ($pkg->is_adult == 1) {
                if ($canAdult) {
                    enable_adult_sponsor(); // アダルトゲームがあれば、広告も変える

                    $sampleImagePackages[] = $pkg->id;
                }
            } else {
                $sampleImagePackages[] = $pkg->id;
            }
        }

        // サンプル画像
        $data['images'] = self::getSampleImages($sampleImagePackages, []);

        // プラットフォームリスト
        $platforms = [];
        foreach ($data['packages'] as $pkg) {
            $platforms[$pkg->platform_id] = $pkg->platform_id;
        }
        $data['platforms'] = $platforms;

        // 公式サイト
        $query = Orm\GameOfficialSite::where('soft_id', $soft->id)
            ->orderBy('priority');
        if (!(Auth::check() && Auth::user()->isAdult())) {
            $query->where('is_adult', 0);
        }

        $data['officialSites'] = $query->get();

        // レビュー
        $data['reviewTotal'] = Orm\ReviewTotal::find($soft->id);
        $data['reviewFearRank'] = '-';
        $data['reviewPointRank'] = '-';
        if ($data['reviewTotal'] != null) {
            $fearRanking = Orm\ReviewFearRanking::find($soft->id);
            $data['reviewFearRank'] = $fearRanking->rank ?? '-';

            $pointRanking = Orm\ReviewPointRanking::find($soft->id);
            $data['reviewPointRank'] = $pointRanking->rank ?? '-';
        }

        // お気に入り登録ユーザー
        $data['favorites'] = self::getFavoriteUser($soft->id);
        $data['favoriteNum'] = Orm\UserFavoriteSoft::where('soft_id', $soft->id)->count(['user_id']);
        $data['followStatus'] = [];
        if (!empty($data['favorite']) && Auth::check()) {
            $data['followStatus'] = User\Follow::getFollowStatus(Auth::id(), array_pluck($data['favorite'], 'user_id'));
        }

        // サイト
        $data['siteNum'] = Orm\SiteSearchIndex::where('soft_id', $soft->id)->count(['site_id']);
        if ($data['siteNum'] > 0) {
            $data['site'] = self::getSite($soft->id, $data['siteNum']);
        } else {
            $data['site'] = null;
        }

        if (Auth::check()) {
            $fav = new FavoriteSoft();
            $data['isFavorite'] = $fav->isFavorite(Auth::id(), $soft->id);
        }

        $data['users'] = User::getHash(array_merge(
            array_pluck($data['favorites'], 'user_id')
        ));

        // 前後のゲーム
        $maxPhoneticOrder = self::getMaxPhoneticOrder();
        $data['prevGame'] = self::getPrevGame($soft, $maxPhoneticOrder);
        $data['nextGame'] = self::getNextGame($soft, $maxPhoneticOrder);

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
        $sql = <<< SQL
SELECT soft.id, soft.name, package.small_image_url, package.medium_image_url, package.large_image_url, package.is_adult
FROM
  (
    SELECT id, `name`, original_package_id, order_in_series
    FROM game_softs
    WHERE series_id = ?
      AND id <> ?
  ) soft
  LEFT OUTER JOIN game_packages package ON package.id = soft.original_package_id
ORDER BY soft.order_in_series
SQL;

        return DB::select($sql, [$seriesId, $softId]);
    }

    /**
     * パッケージの一覧を取得
     *
     * @param int $softId
     * @return array
     */
    public static function getPackages($softId)
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

        $appendQuery = '';
        if (!Auth::check()) {
            $appendQuery = 'AND is_adult <> 1' . PHP_EOL;
        }

        $sql = <<< SQL
SELECT pkg.*, plt.name AS platform_name, com.name AS company_name
FROM (
  SELECT id, `name`, platform_id, release_at, company_id, medium_image_url, small_image_url, large_image_url, is_adult, release_int, url
  FROM game_packages
  WHERE id IN ({$packageIdsComma}) {$appendQuery}
) pkg
  LEFT OUTER JOIN game_platforms plt ON pkg.platform_id = plt.id
  LEFT OUTER JOIN game_companies com ON pkg.company_id = com.id
ORDER BY
  pkg.release_int DESC, plt.sort_order DESC, pkg.id
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
        $sql = <<< SQL
SELECT users.id AS user_id, users.name, users.show_id, users.icon_upload_flag
  , users.icon_file_name, users.icon_round_type
FROM (
    SELECT user_id
    FROM user_favorite_softs
    WHERE soft_id = :soft_id
    ORDER BY id DESC
) fav INNER JOIN users on fav.user_id = users.id
WHERE users.open_profile_flag
SQL;

        if (Auth::check()) {
            // 誰でももしくはメンバーのみ
            $sql .= ' IN (1, 2)';
        } else {
            // 誰でもに公開している場合のみ
            $sql .= ' = 2';
        }

        $sql .= PHP_EOL . 'LIMIT 20';

        return DB::select($sql, ['soft_id' => $softId]);
    }

    /**
     * ランダムピックアップサイト
     *
     * @param int $softId
     * @param int $siteNum
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    private static function getSite($softId, $siteNum)
    {
        $idx = rand(0, $siteNum - 1);

        $siteIds = DB::table('site_search_indices')
            ->select(['site_id'])
            ->where('soft_id', $softId)
            ->limit(1)
            ->offset($idx)
            ->first();

        if (empty($siteIds)) {
            return null;
        }

        return Orm\Site::find($siteIds->site_id);
    }

    /**
     * 遊んだプレーヤーを取得
     *
     * @param int $softId
     * @return array
     */
    private static function getPlayedUsers($softId)
    {
        $sql = <<< SQL
SELECT users.id, users.name, users.show_id
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
     * @throws \Exception
     */
    public static function save(Orm\GameSoft $soft, $isWriteTimeine)
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

            throw $e;
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

    /**
     * オリジナルパッケージIDの更新
     *
     * @param $isAll
     */
    public static function updateOriginalPackageId($isAll)
    {
        if ($isAll) {
            $softs = Orm\GameSoft::where('original_package_id', null)
                ->get();
        } else {
            $softs = Orm\GameSoft::all();
        }

        foreach ($softs as $soft) {

            // Mirage～淫宴の触手病棟～ Another Story Of D'ERLANGER
            if ($soft->id == 321) {
                // No Imageという画像になっているので、DVD-PGを採用
                $soft->original_package_id = 632;
                $soft->save();
                continue;
            }

            $pkg = Orm\GamePackageLink::where('soft_id', $soft->id)
                ->get()
                ->pluck('package_id')
                ->toArray();

            if (!empty($pkg)) {
                $orgPkg = DB::table('game_packages')
                    ->whereIn('id', $pkg)
                    ->orderBy('release_int')
                    ->orderBy('platform_id')
                    ->orderBy('id')
                    ->get();

                if (!empty($orgPkg)) {
                    // 最初のものをオリジナルとする
                    $soft->original_package_id = $orgPkg[0]->id;

                    // が、パッケージ画像がなかったら、最初に見つあったものをオリジナルとする
                    foreach ($orgPkg as $p) {
                        if (!empty($p->medium_image_url)) {
                            $soft->original_package_id = $p->id;
                            break;
                        }
                    }

                    $soft->save();
                } else {
                    echo $soft->name . ' is no original package.' . PHP_EOL;
                }
            } else {
                echo $soft->name . ' is no original package.' . PHP_EOL;
            }
        }
    }

    /**
     * phonetic_orderの最大値を取得
     *
     * @return mixed
     */
    private static function getMaxPhoneticOrder()
    {
        return Orm\GameSoft::query()
            ->max('phonetic_order');
    }


    private static function getPrevGame(Orm\GameSoft $soft, $maxPhoneticOrder)
    {
        if ($soft->phonetic_order == 1) {
            return Orm\GameSoft::where('phonetic_order', $maxPhoneticOrder)
                ->first();
        } else {
            return Orm\GameSoft::where('phonetic_order', $soft->phonetic_order - 1)
                ->first();
        }
    }

    private static function getNextGame(Orm\GameSoft $soft, $maxPhoneticOrder)
    {
        if ($soft->phonetic_order == $maxPhoneticOrder) {
            return Orm\GameSoft::where('phonetic_order', 1)->first();
        } else {
            return Orm\GameSoft::where('phonetic_order', $soft->phonetic_order + 1)->first();
        }
    }

    /**
     * 総ソフト数を取得
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getNum()
    {
        return DB::table('game_softs')
            ->select([DB::raw('COUNT(id) AS num')])
            ->get()
            ->first()->num;
    }

    /**
     * サンプル画像を取得
     *
     * @param array $packageIds
     * @return \Illuminate\Support\Collection
     */
    public static function getSampleImages(array $packageIds)
    {
        return DB::table('game_soft_sample_images')
            ->whereIn('package_id', $packageIds)
            ->orderBy('no')
            ->get();
    }

    /**
     * 一覧用データ取得
     *
     * @param bool $isGuest
     * @return array
     */
    public static function getListForSearch($isGuest)
    {
        // TODO このデータはMongoDBに移してそっちでやる

        $query = DB::table('game_softs')
            ->select(['id', 'name', 'phonetic']);

        if ($isGuest) {
            $query->where('adult_only_flag', 0);
        }

        return $query->get()->toJson();
    }
}