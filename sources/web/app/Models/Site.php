<?php
/**
 * サイトモデル
 */

namespace Hgs3\Models;

use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Hgs3\Models\Timeline;

class Site
{
    /**
     * 登録
     *
     * @param User $user
     * @param Orm\Site $site
     * @param string $handleSoftsComma
     */
    public static function save(User $user, Orm\Site $site, $handleSoftsComma)
    {
        $isAdd = $site->id === null;

        $handleSoftIds = explode(',', $handleSoftsComma);

        if (!$isAdd) {
            // タイムライン用に現在の取扱いゲームを取得
            $prevHandleSoftIds = DB::table('site_handle_softs')
                ->select(['game_id'])
                ->where('site_id', $site->id)
                ->get()
                ->pluck('soft_id', 'soft_id')
                ->toArray();
        }

        DB::beginTransaction();
        try {
            $site->save();

            self::saveHandleSofts($site->user_id, $handleSoftIds);

            self::saveSearchIndex($site, $handleSoftIds);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

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

            // 直前に取りつかってないゲームを追加
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

        if (!empty($handleSoftIds)) {
            $data = [];
            foreach ($handleSoftIds as $softId) {
                if (!empty($softId)) {
                    $data[] = [
                            'site_id' => $siteId,
                            'soft_id' => $softId
                        ];
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

        foreach ($handleSoftIds as $softId) {
            DB::insert($sql, [$site->id, $softId, $site->main_contents_id, $site->gender, $site->rate]);
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
        $data['newcomer'] = self::getNewcomer();

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
     * 新着サイト
     *
     * @return \Illuminate\Support\Collection
     */
    private static function getNewcomer()
    {
        return DB::table('sites')
            ->orderBy('registered_timestamp', 'DESC')
            ->take(5)
            ->get();
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
            ->get();
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
    public static function getHandleSofts($siteId)
    {
        return Orm\SiteHandleSoft::where('site_id', $siteId)
            ->select(['soft_id'])
            ->get()
            ->pluck('soft_id')
            ->toArray();
    }
}