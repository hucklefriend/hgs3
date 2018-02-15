<?php
/**
 * 更新サイト
 */

namespace Hgs3\Models\Site;

use Hgs3\Constants\Site\ApprovalStatus;
use Hgs3\Log;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;

class UpdateArrival
{
    /**
     * 更新サイトを取得
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
     * 登録
     *
     * @param $siteId
     */
    public static function add($siteId)
    {
        $sql =<<< SQL
INSERT INTO site_update_arrivals (
  site_id, updated_timestamp, created_at, updated_at
) VALUES (
  ?, UNIX_TIMESTAMP(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
) ON DUPLICATE KEY UPDATE
  updated_timestamp = VALUES(updated_timestamp)
  , updated_at = VALUES(updated_at)
SQL;

        DB::insert($sql, [$siteId]);
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
}