<?php
/**
 * 新着サイト
 */

namespace Hgs3\Models\Site;

use Hgs3\Models\Timeline;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NewArrival
{
    /**
     * 新着サイトを取得
     *
     * @param $num
     * @return \Illuminate\Support\Collection
     */
    public static function get($num)
    {
        return DB::table('site_new_arrivals')
            ->select(['site_id'])
            ->orderBy('registered_date', 'DESC')
            ->take($num)
            ->get()
            ->toArray();
    }

    /**
     * 登録
     *
     * @param $siteId
     */
    public static function add($siteId)
    {
        DB::table('site_new_arrivals')
            ->insert([
                'site_id'              => $siteId,
                'registered_timestamp' => time(),
                'created_at'           => DB::raw('CURRENT_TIMESTAMP'),
                'updated_at'           => DB::raw('CURRENT_TIMESTAMP')
            ]);
    }

    /**
     * 削除
     *
     * @param $siteId
     */
    public static function delete($siteId)
    {
        DB::table('site_new_arrivals')
            ->where('site_id', $siteId)
            ->delete();
    }

    /**
     * 古くなったサイトを削除
     */
    public static function deleteOld()
    {
        $deleteTimestamp = time() - 86400 * 30;     // 30日前のタイムスタンプ

        try {
            DB::table('site_new_arrivals')
                ->where('registered_timestamp', '<=', $deleteTimestamp)
                ->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return true;
    }
}