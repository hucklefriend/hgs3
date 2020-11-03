<?php
/**
 * 新着サイト
 */

namespace Hgs3\Models\Site;

use Hgs3\Log;
use Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class NewArrival
{
    /**
     * 新着サイトを取得
     *
     * @param $num
     * @return Collection|static[]
     * @throws \Exception
     */
    public static function get($num)
    {
        $lastMonth = new \DateTime();
        $lastMonth->sub(new \DateInterval('P1M'));

        $newArrivals = Orm\SiteNewArrival::select()
            ->where('registered_timestamp', '>', $lastMonth->format('u'))
            ->orderBy('registered_timestamp', 'DESC')
            ->take($num)
            ->get()
            ->pluck('site_id')
            ->toArray();

        if (empty($newArrivals)) {
            return new Collection();
        }

        return Orm\Site::whereIn('id', $newArrivals)
            ->orderBy('registered_timestamp', 'DESC')
            ->get();
    }

    /**
     * 新着サイト一覧情報を取得
     *
     * @param $pagePerNum
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws \Exception
     */
    public static function getPage($pagePerNum)
    {
        $lastMonth = new \DateTime();
        $lastMonth->sub(new \DateInterval('P1M'));

        return Orm\SiteNewArrival::select()
            ->where('registered_timestamp', '>', $lastMonth->format('u'))
            ->orderBy('registered_timestamp', 'DESC')
            ->paginate($pagePerNum);
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