<?php
/**
 * 新着サイト
 */

namespace Hgs3\Models\Site;

use Hgs3\Log;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;

class NewArrival
{
    /**
     * 新着サイトを取得
     *
     * @param int $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws \Exception
     */
    public static function get($num)
    {
        $lastMonth = new \DateTime();
        $lastMonth->sub(new \DateInterval('P1M'));

        return Orm\SiteNewArrival::where('registered_timestamp', '>', $lastMonth->format('u'))
            ->orderBy('registered_timestamp', 'DESC')
            ->paginate($num);
    }

    /**
     * 更新サイトを取得
     *
     * @param int $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws \Exception
     */
    public static function getUpdated($num)
    {
        $lastMonth = new \DateTime();
        $lastMonth->sub(new \DateInterval('P1M'));

        return Orm\Site::where('updated_timestamp', '>', $lastMonth->format('u'))
            ->orderBy('updated_timestamp', 'DESC')
            ->paginate($num);
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
            Log::exceptionError($e);

            return false;
        }

        return true;
    }
}