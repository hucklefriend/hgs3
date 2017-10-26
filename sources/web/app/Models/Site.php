<?php
/**
 * サイトモデル
 */

namespace Hgs3\Models;

use Hgs3\Models\Orm;
use Hgs3\Models\Site\Footprint;
use Hgs3\Models\Site\NewArrival;
use Hgs3\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Hgs3\Models\Timeline;

class Site
{
    /**
     * 登録
     *
     * @param \Hgs3\Models\User $user
     * @param Orm\Site $site
     * @param $handleSoftsComma
     * @param UploadedFile|null $listBanner
     * @param UploadedFile|null $detailBanner
     * @return bool
     */
    public static function save(User $user, Orm\Site $site, ?UploadedFile $listBanner, ?UploadedFile $detailBanner)
    {
        $isAdd = $site->id === null;

        $handleSoftIds = explode(',', $site->handle_soft);

        if (!$isAdd) {
            // タイムライン用に現在の取扱いゲームを取得
            $prevHandleSoftIds = DB::table('site_handle_softs')
                ->select(['soft_id'])
                ->where('site_id', $site->id)
                ->get()
                ->pluck('soft_id', 'soft_id')
                ->toArray();
        }

        DB::beginTransaction();
        try {
            if (!$isAdd) {
                // 更新の場合はサイトIDがわかるので、先にバナー保存
                self::saveBanner($site, $listBanner, $detailBanner);
            }

            $site->save();

            self::saveHandleSofts($site->id, $handleSoftIds);

            self::saveSearchIndex($site, $handleSoftIds);

            if ($isAdd) {
                // 追加の場合はサイトIDの確定が必要なので、後でバナー保存
                self::saveBanner($site, $listBanner, $detailBanner);
                $site->save();

                // TODO 新着サイトに登録
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            if (env('APP_ENV') == 'local') {
                throw $e;
            }

            return false;
        }

        // タイムライン
        if ($isAdd) {
            Timeline\FollowUser::addAddSiteText($user, $site);

            if (!empty($handleSoftIds)) {
                $softHash = Orm\GameSoft::getHash($handleSoftIds);
                foreach ($handleSoftIds as $softId) {
                    if (isset($softHash[$softId])) {
                        Timeline\FavoriteSoft::addNewSiteText($softHash[$softId], $site);
                    }
                }
                unset($softHash);
            }
        } else {
            Timeline\FollowUser::addUpdateSiteText($user, $site);

            // 直前に取り扱ってないゲームを追加
            $softHash = Orm\GameSoft::getHash($handleSoftIds);
            foreach ($handleSoftIds as $softId) {
                if (!isset($prevHandleSoftIds[$softId]) && isset($softHash[$softId])) {
                    Timeline\FavoriteSoft::addNewSiteText($softHash[$softId], $site);
                }
            }
        }

        return true;
    }

    /**
     * バナー情報の保存
     *
     * @param Orm\Site $site
     * @param UploadedFile|null $listBanner
     * @param UploadedFile|null $detailBanner
     */
    private static function saveBanner(Orm\Site $site, ?UploadedFile $listBanner, ?UploadedFile $detailBanner)
    {
        $bannerDirectoryPath = base_path() . '/public/img/site_banner/' . $site->id;

        // バナー用ディレクトリ作成
        if (!File::exists($bannerDirectoryPath)) {
            File::makeDirectory($bannerDirectoryPath);
        }

        // 一覧用バナーに何かしら変更が発生する
        if ($site->list_banner_upload_flag != -1) {
            // 今何かファイルが上がっていたら削除
            if (!empty($site->list_banner_url)) {
                $listBannerFileName = 'list.' . substr($site->list_banner_url, strrpos($site->list_banner_url, '.'));

                if (File::exists($bannerDirectoryPath . '/' . $listBannerFileName)) {
                    File::delete($bannerDirectoryPath . '/' . $listBannerFileName);
                }
            }

            if ($site->list_banner_upload_flag == 2 && $listBanner !== null) {
                // アップロード
                $listBannerFileName = 'list.' . $listBanner->getClientOriginalExtension();

                if (File::exists($bannerDirectoryPath . '/' . $listBannerFileName)) {
                    File::delete($bannerDirectoryPath . '/' . $listBannerFileName);
                }

                $listBanner->move($bannerDirectoryPath, $listBannerFileName);
                $site->list_banner_url = url2('img/site_banner/' . $site->id . '/' . $listBannerFileName);
            } else if ($site->list_banner_upload_flag == 0) {
                // 削除(またはアップしない)
                $site->list_banner_url = null;
            }
        }

        // 詳細用バナーに何かしら変更が発生する
        if ($site->detail_banner_upload_flag != -1) {
            // 今何かファイルが上がっていたら削除
            if (!empty($site->detail_banner_url)) {
                $detailBannerFileName = 'detail.' . substr($site->detail_banner_url, strrpos($site->detail_banner_url, '.'));
                if (File::exists($bannerDirectoryPath . '/' . $detailBannerFileName)) {
                    File::delete($bannerDirectoryPath . '/' . $detailBannerFileName);
                }
            }

            if ($site->detail_banner_upload_flag == 2 && $detailBanner !== null) {
                // アップロード
                $detailBannerFileName = 'detail.' . $detailBanner->getClientOriginalExtension();
                if (File::exists($bannerDirectoryPath . '/' . $detailBannerFileName)) {
                    File::delete($bannerDirectoryPath . '/' . $detailBannerFileName);
                }
                $detailBanner->move($bannerDirectoryPath, $detailBannerFileName);
                $site->detail_banner_url = url2('img/site_banner/' . $site->id . '/' . $detailBannerFileName);
            } else if ($site->detail_banner_upload_flag == 0) {
                // 削除(またはアップしない)
                $site->detail_banner_url = null;
            }
        }
    }

    /**
     * 取扱いゲームを保存
     *
     * @param int $siteId
     * @param array $handleSoftIds
     */
    private static function saveHandleSofts($siteId, array $handleSoftIds)
    {
        DB::table('site_handle_softs')
            ->where('site_id', $siteId)
            ->delete();

        $hash = [];

        Log::debug('---------');
        Log::debug($siteId);
        Log::debug(var_export($handleSoftIds, true));

        if (!empty($handleSoftIds)) {
            $data = [];
            foreach ($handleSoftIds as $softId) {
                if (!empty($softId) && !isset($hash[$softId])) {
                    $data[] = [
                            'site_id' => $siteId,
                            'soft_id' => $softId
                        ];
                    $hash[$softId] = 1;
                }
            }

            DB::table('site_handle_softs')->insert($data);
        }
    }

    /**
     * 検索インデックステーブルに保存
     *
     * @param Orm\Site $site
     * @param array $handleSoftIds
     */
    private static function saveSearchIndex(Orm\Site $site, array $handleSoftIds)
    {
        // 先に消す
        DB::table('site_search_indices')
            ->where('site_id', $site->id)
            ->delete();

        // 登録
        $sql =<<< SQL
INSERT IGNORE INTO site_search_indices (site_id, soft_id, main_contents_id, gender, rate, updated_timestamp, created_at, updated_at)
VALUES (?, ?, ?, ?, ?, UNIX_TIMESTAMP(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
SQL;

        $hash = [];
        foreach ($handleSoftIds as $softId) {
            if (!isset($hash[$softId])) {
                DB::insert($sql, [$site->id, $softId, $site->main_contents_id, $site->gender, $site->rate]);
                $hash[$softId] = 1;
            }
        }
    }

    /**
     * トップページ用データの取得
     *
     * @return array
     */
    public static function getIndexData()
    {
        $data = [];

        // 新着サイト
        $data['newArrivals'] = NewArrival::get(5);

        // 更新サイト
        $data['updated'] = self::getLatestUpdate();

        // 人気サイト
        $data['good'] = self::getGoodRanking();

        // アクセス数
        $data['access'] = self::getAccessRanking();

        $userIds = array_merge(
            $data['newcomer']->pluck('user_id')->toArray(),
            $data['updated']->pluck('user_id')->toArray(),
            $data['newcomer']->pluck('user_id')->toArray(),
            $data['access']->pluck('user_id')->toArray()
        );

        $data['users'] = User::getNameHash($userIds);

        return $data;
    }

    /**
     * 更新日時の新しいサイト
     *
     * @return \Illuminate\Support\Collection
     */
    private static function getLatestUpdate()
    {
        return DB::table('sites')
            ->orderBy('updated_timestamp', 'DESC')
            ->take(5)
            ->get()
            ->toArray();
    }

    /**
     * OUT数が多いサイト
     *
     * @return \Illuminate\Support\Collection
     */
    private static function getAccessRanking()
    {
        return DB::table('sites')
            ->orderBy('out_count', 'DESC')
            ->take(5)
            ->get();
    }

    /**
     * いいね数が多いサイト
     *
     * @return \Illuminate\Support\Collection
     */
    private static function getGoodRanking()
    {
        return DB::table('sites')
            ->orderBy('good_num', 'DESC')
            ->take(5)
            ->get();
    }

    /**
     * ユーザーのサイトを取得
     *
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function get($userId)
    {
        return Orm\Site::where('user_id', $userId)
            ->orderBy( 'id')
            ->get();
    }

    /**
     * 検索
     *
     * @param Orm\GameSoft $soft
     * @param int $mainContents
     * @param int $targetGender
     * @param int $rate
     * @param int $pagePerNum
     * @return array
     */
    public static function search(Orm\GameSoft $soft, $mainContents, $targetGender, $rate, $pagePerNum)
    {
        $data = ['soft' => $soft];

        // 検索テーブルからIDを取得
        $data['pager'] = DB::table('site_search_indices')
            ->select('site_id')
            ->where('soft_id', '=', $soft->id)
            //->where('main_contents_id', '=', $mainContents)
            //->where('gender', '=', $targetGender)
            //->where('rate', '=', $rate)
            ->orderBy('updated_timestamp', 'DESC')
            ->paginate($pagePerNum);

        $data['sites'] = [];
        if (!empty($data['pager'])) {
            $data['sites'] = Orm\Site::getHash(array_pluck($data['pager']->items(), 'site_id'));
            $data['users'] = User::getNameHash(array_pluck($data['sites'], 'user_id'));
        }

        return $data;
    }

    /**
     * 取扱いゲームのIDを取得
     *
     * @param int $siteId
     * @return \Illuminate\Support\Collection
     */
    public static function getHandleSoftIds($siteId)
    {
        return Orm\SiteHandleSoft::where('site_id', $siteId)
            ->select(['soft_id'])
            ->get()
            ->pluck('soft_id')
            ->toArray();
    }

    /**
     * オリジナルパッケージ情報付きでソフトデータを取得
     *
     * @param int $siteId
     * @return array
     */
    public static function getSoftWithOriginalPackage($siteId)
    {
        $softIds = self::getHandleSoftIds($siteId);
        if (empty($softIds)) {
            return [];
        }

        $softIdsComma = implode(',', $softIds);

        $sql =<<< SQL
SELECT soft.id, soft.name, package.small_image_url 
FROM (
SELECT * FROM game_softs WHERE id IN ({$softIdsComma})
) soft LEFT OUTER JOIN game_packages AS package ON soft.original_package_id = package.id
SQL;

        return DB::select($sql);
    }

    /**
     * サイトを削除
     *
     * @param Orm\Site $site
     * @return bool
     */
    public static function delete(Orm\Site $site)
    {
        /**
         * タイムラインは残しておく
         */

        DB::beginTransaction();
        try {
            // 足跡を削除
            Footprint::delete($site->id);

            DB::table('user_favorite_sites')
                ->where('site_id', $site->id)
                ->delete();

            DB::table('site_handle_softs')
                ->where('site_id', $site->id)
                ->delete();

            DB::table('site_search_indices')
                ->where('site_id', $site->id)
                ->delete();

            NewArrival::delete($site->id);

            DB::table('site_goods')
                ->where('site_id', $site->id)
                ->delete();

            DB::table('site_good_histories')
                ->where('site_id', $site->id)
                ->delete();

            $site->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getMessage());

            if (env('APP_ENV') == 'local') {
                throw $e;
            }

            return false;
        }

        return true;
    }
}