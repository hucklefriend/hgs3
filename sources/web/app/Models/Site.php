<?php
/**
 * サイトモデル
 */

namespace Hgs3\Models;

use Hgs3\Constants\Site\ApprovalStatus;
use Hgs3\Constants\Site\OpenType;
use Hgs3\Models\Orm;
use Hgs3\Models\Site\Footprint;
use Hgs3\Models\Site\NewArrival;
use Hgs3\Models\Site\UpdateArrival;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Timeline;
use Illuminate\Support\Facades\Mail;
use Hgs3\Log;

class Site
{
    /**
     * 登録
     *
     * @param User $user
     * @param Orm\Site $site
     * @throws \Exception
     */
    public static function insert(User $user, Orm\Site $site)
    {
        // Laravelの方でカンマ区切りは配列にしてくれるっぽい？
        if (is_array($site->handle_soft)) {
            // カンマ区切りに変換
            $handleSoftIds = $site->handle_soft;
            $site->handle_soft = implode(',', $site->handle_soft);
        } else {
            $handleSoftIds = explode(',', $site->handle_soft);
        }

        $site->approval_status = ApprovalStatus::DRAFT;     // 下書き

        DB::beginTransaction();
        try {
            // 先にINSERTしてサイトIDを確定
            $site->save();

            // 取扱いゲームを保存
            self::saveHandleSofts($site, $handleSoftIds);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);
        }

        try {
            // 管理人のタイムラインに流す
            $admin = User::getAdmin();
            Timeline\ToMe::addSiteApproveText($admin, $site);

            // 管理人にメール送信
            if (env('APP_ENV') == 'production') {
                Mail::to(env('ADMIN_MAIL'))
                    ->send(new \Hgs3\Mail\SiteApprovalWait($site));

                Log::info('管理人にメール飛ばした');
            }
        } catch (\Exception $e) {
            Log::exceptionError($e);
        }
    }

    /**
     * 更新
     *
     * @param User $user
     * @param Orm\Site $site
     * @throws \Exception
     */
    public static function update(User $user, Orm\Site $site)
    {
        // カンマ区切りを配列にしてくれるっぽい？
        if (is_array($site->handle_soft)) {
            $handleSoftIds = $site->handle_soft;
            $site->handle_soft = implode(',', $site->handle_soft);
        } else {
            $handleSoftIds = explode(',', $site->handle_soft);
        }

        $isApproved = $site->approval_status == ApprovalStatus::OK;   // 承認済み？
        if ($isApproved) {
            $site->updated_timestamp = time();
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
            self::saveHandleSofts($site, $handleSoftIds);
            $site->save();

            if ($isApproved) {
                // 承認済みサイトの更新
                UpdateArrival::add($site->id);                  // 更新サイト
                self::saveSearchIndex($site, $handleSoftIds);   // 検索インデックス更新
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);

            return false;
        }

        // サイト追加タイムライン
        if ($isApproved) {
            // サイト更新タイムライン
            self::registerUpdateTimeline($user, $site);

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
     * サイト更新タイムラインの保存
     *
     * @param User $user
     * @param Orm\Site $site
     */
    public static function registerUpdateTimeline(User $user, Orm\Site $site)
    {
        if ($site->approval_status == ApprovalStatus::OK) {
            Timeline\FollowUser::addUpdateSiteText($user, $site);
            Timeline\ToMe::addSiteUpdatedText($user, $site);
            Timeline\FavoriteSite::addUpdateSiteText($site);
            Timeline\Site::addUpdateText($site);
            Timeline\NewInformation::addUpdateSiteText($site);
            Timeline\UserActionTimeline::addSiteUpdateText($user, $site);
        }
    }

    /**
     * 取扱いゲームを保存
     *
     * @param Orm\Site $site
     * @param array $handleSoftIds
     */
    public static function saveHandleSofts(Orm\Site $site, ?array $handleSoftIds = null)
    {
        if ($handleSoftIds === null) {
            $handleSoftIds = explode(',', $site->handle_soft);
        }

        DB::table('site_handle_softs')
            ->where('site_id', $site->id)
            ->delete();

        $hash = [];

        if (!empty($handleSoftIds)) {
            $data = [];
            foreach ($handleSoftIds as $softId) {
                if (!empty($softId) && !isset($hash[$softId])) {
                    $data[] = [
                        'site_id' => $site->id,
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
    public static function saveSearchIndex(Orm\Site $site, ?array $handleSoftIds = null)
    {
        if ($handleSoftIds === null) {
            $handleSoftIds = explode(',', $site->handle_soft);
        }

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
     * 日別アクセス数をコピー
     *
     * @param $siteId
     * @param $hgs2SiteId
     */
    private static function takeOverDailyAccess($siteId, $hgs2SiteId)
    {
        $sql =<<< SQL
INSERT INTO site_daily_accesses
  (site_id, `date`, in_count, out_count, created_at, updated_at)
SELECT
  {$siteId} AS site_id, FROM_UNIXTIME(`day`, '%Y%m%d'), `out`, `in`, FROM_UNIXTIME(registered_date), FROM_UNIXTIME(updated_date)
FROM
  hgs2.hgs_u_site_access_daily
ON DUPLICATE KEY UPDATE
  `out_count` = VALUES(`out_count`)
  , `in_count` = VALUES(`in_count`)
  , `updated_at` = VALUES(`updated_at`)
SQL;

        DB::insert($sql, [$hgs2SiteId, $siteId]);
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
        $data['newArrivals'] = self::getNewArrival();

        // 更新サイト
        $data['updated'] = self::getLatestUpdate();

        // 人気サイト
        $data['good'] = self::getGoodRanking();

        // アクセス数
        $data['access'] = self::getAccessRanking();

        $userIds = array_merge(
            array_pluck($data['newArrivals'],'user_id'),
            array_pluck($data['updated'], 'user_id'),
            array_pluck($data['good'], 'user_id'),
            array_pluck($data['access'], 'user_id')
        );

        $data['users'] = User::getHash($userIds);

        return $data;
    }

    /**
     * 新着サイトを取得
     *
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    private static function getNewArrival()
    {
        $arrivals = NewArrival::get(5);
        if (empty($arrivals)) {
            return [];
        }

        Log::debug(var_export($arrivals, true));

        return Orm\Site::whereIn('id', $arrivals)
            ->orderBy('updated_timestamp', 'DESC')
            ->get();
    }

    /**
     * 更新日時の新しいサイト
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    private static function getLatestUpdate()
    {
        return Orm\Site::where('approval_status', ApprovalStatus::OK)
            ->orderBy('updated_timestamp', 'DESC')
            ->take(5)
            ->get();
    }

    /**
     * OUT数が多いサイト
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    private static function getAccessRanking()
    {
        return Orm\Site::where('approval_status', ApprovalStatus::OK)
            ->orderBy('out_count', 'DESC')
            ->take(5)
            ->get();
    }

    /**
     * いいね数が多いサイト
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    private static function getGoodRanking()
    {
        return Orm\Site::where('approval_status', ApprovalStatus::OK)
            ->orderBy('good_num', 'DESC')
            ->take(5)
            ->get();
    }

    /**
     * ユーザーのサイトを取得
     *
     * @param int $userId
     * @param bool $isWebmaster
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getUserSites($userId, $isWebmaster = false)
    {
        $query = Orm\Site::where('user_id', $userId);

        if (!$isWebmaster) {
            $query->where('approval_status', ApprovalStatus::OK);
                //->where('open_type', OpenType::ALL);
        }

        return $query
            ->orderBy( 'id')
            ->get();
    }

    /**
     * 検索
     *
     * @param Orm\GameSoft|null $soft
     * @param array|null $mainContents
     * @param array|null $targetGender
     * @param array|null $rate
     * @param int $pagePerNum
     * @return array
     */
    public static function search(?Orm\GameSoft $soft, ?array $mainContents, ?array $targetGender, ?array $rate, $pagePerNum)
    {
        $data = ['soft' => $soft];

        $query = DB::table('site_search_indices')
            ->select('site_id');

        if ($soft !== null) {
            $query->where('soft_id', '=', $soft->id);
        }
        if ($mainContents !== null && !empty($mainContents)) {
            $query->whereIn('main_contents_id', $mainContents);
        }
        if ($targetGender !== null && !empty($targetGender)) {
            $query->whereIn('gender', $targetGender);
        }
        if ($rate !== null && !empty($rate)) {
            $query->whereIn('rate', $rate);
        }

        $query->groupBy('site_id')
            ->orderBy('updated_timestamp', 'DESC');

        // 検索テーブルからIDを取得
        $data['pager'] = $query->paginate($pagePerNum);



        $data['sites'] = [];
        if (!empty($data['pager'])) {
            $data['sites'] = Orm\Site::getHash(page_pluck($data['pager'], 'site_id'));
            $data['users'] = User::getHash(array_pluck($data['sites'], 'user_id'));
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
SELECT soft.id, soft.name, package.small_image_url, package.medium_image_url, package.large_image_url, package.is_adult
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
     * @throws \Exception
     */
    public static function delete(Orm\Site $site)
    {
        /**
         * タイムラインは残しておく
         */

        DB::beginTransaction();
        try {
            self::deleteNoTransaction($site);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::exceptionError($e);

            return false;
        }

        return true;
    }

    /**
     * トランザクションなしで削除
     *
     * @param Orm\Site $site
     * @throws \Exception
     */
    public static function deleteNoTransaction(Orm\Site $site)
    {
        // 足跡を削除
        Footprint::delete($site->id);

        // お気に入りサイト
        Orm\UserFavoriteSite::where('site_id', $site->id)
            ->delete();

        // 取扱いゲーム
        Orm\SiteHandleSoft::where('site_id', $site->id)
            ->delete();

        // サイト検索インデックス
        Orm\SiteSearchIndex::where('site_id', $site->id)
            ->delete();

        // 新着サイト
        NewArrival::delete($site->id);

        // 更新サイト
        Orm\SiteUpdateArrival::where('site_id', $site->id)
            ->delete();

        // サイトいいね
        Orm\SiteGood::where('site_id', $site->id)
            ->delete();

        // サイトいいね履歴
        Orm\SiteGoodHistory::where('site_id', $site->id)
            ->delete();

        // サイト更新履歴
        Orm\SiteUpdateHistory::where('site_id', $site->id)
            ->delete();

        // 日別アクセス数
        Orm\SiteDailyAccess::where('site_id', $site->id)
            ->delete();

        // サイト自体
        $site->delete();
    }

    /**
     * アクセス
     *
     * @param Orm\Site $site
     * @return bool
     * @throws \Exception
     */
    public static function access(Orm\Site $site)
    {
        DB::beginTransaction();
        try {
            // 日単位をアクセス数加算
            $sql =<<< SQL
INSERT INTO site_daily_accesses (
  site_id, `date`, in_count, out_count, created_at, updated_at
) VALUES (
  ?, CURDATE(), 0, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
)
ON DUPLICATE KEY UPDATE
  out_count = out_count + 1
  , updated_at = CURRENT_TIMESTAMP
SQL;

            DB::insert($sql, [$site->id]);

            // 累計アクセス数加算
            DB::table('sites')
                ->where('id', $site->id)
                ->update([
                    'out_count' => DB::raw('out_count + 1')
                ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);
            return false;
        }

        $site->out_count++;     // DBから取り直すべきだけど、そこまで厳密にやらなくてもいいか
        Timeline\Site::addAccessNumText($site);
        Timeline\FavoriteSite::addAccessNumText($site);

        return true;
    }

    /**
     * 登録数を超えていないか
     *
     * @param $userId
     * @return bool
     */
    public static function isMax($userId)
    {
        return DB::table('sites')
            ->where('user_id', $userId)
            ->count('id') >= env('MAX_SITES');
    }

    /**
     * 新着サイトのお知らせやタイムラインなどを登録
     *
     * @param User $user
     * @param Orm\Site $site
     * @param array $handleSoftIds
     * @throws \Exception
     */
    public static function saveNewSiteInformation(User $user, Orm\Site $site, array $handleSoftIds)
    {
        try {
            // フォローユーザータイムライン
            Timeline\FollowUser::addAddSiteText($user, $site);
            // 個人タイムライン
            Timeline\ToMe::addSiteRegisteredText($user, $site);

            if (!empty($handleSoftIds)) {
                $softHash = Orm\GameSoft::getHash($handleSoftIds);
                foreach ($handleSoftIds as $softId) {
                    if (isset($softHash[$softId])) {
                        // お気に入りゲームソフトタイムライン
                        Timeline\FavoriteSoft::addNewSiteText($softHash[$softId], $site);
                    }
                }
                unset($softHash);
            }

            // サイトタイムライン
            Timeline\Site::addNewArrivalText($site);

            // 新着情報
            Timeline\NewInformation::addNewSiteText($site);
        } catch (\Exception $e) {
            Log::exceptionError($e);
        }
    }

    /**
     * 更新履歴の登録
     *
     * @param Orm\Site $site
     * @param Orm\SiteUpdateHistory $siteUpdateHistory
     * @param bool $addTimeline
     * @return bool
     * @throws \Exception
     */
    public static function saveUpdateHistory(Orm\Site $site, Orm\SiteUpdateHistory $siteUpdateHistory, $addTimeline)
    {
        DB::beginTransaction();
        try {
            $sql =<<< SQL
INSERT INTO site_update_histories (site_id, site_updated_at, detail, created_at, updated_at)
VALUES (:site_id, :site_updated_at, :detail, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
ON DUPLICATE KEY UPDATE
  site_id = VALUES(site_id),
  site_updated_at = VALUES(site_updated_at),
  detail = VALUES(detail),
  updated_at = VALUES(updated_at)
SQL;

            DB::insert($sql, [
                'site_id'         => $site->id,
                'site_updated_at' => $siteUpdateHistory->site_updated_at,
                'detail'          => $siteUpdateHistory->detail
            ]);

            $site->updated_timestamp = time();
            $site->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::exceptionError($e);
            return false;
        }

        // サイト更新タイムライン
        if ($addTimeline) {
            $user = User::find($site->user_id);
            Timeline\FollowUser::addUpdateSiteText($user, $site);
            Timeline\ToMe::addSiteUpdatedText($user, $site);
            Timeline\FavoriteSite::addUpdateSiteText($site);
            Timeline\Site::addUpdateText($site);
        }

        return true;
    }

    /**
     * サイト数を取得
     *
     * @return mixed
     */
    public static function getNum()
    {
        return DB::table('sites')
            ->select([DB::raw('COUNT(id) num')])
            ->where('approval_status', ApprovalStatus::OK)
            ->get()
            ->first()
            ->num;
    }

    public static function deleteTestData($isAll)
    {
        $q = Orm\Site::where('id', '<=', 766);
        if (!$isAll) {
            $q->where('approval_status', '<>', ApprovalStatus::OK);
        }

        $sites = $q->get();

        foreach ($sites as $site) {
            self::delete($site);
        }
    }
}