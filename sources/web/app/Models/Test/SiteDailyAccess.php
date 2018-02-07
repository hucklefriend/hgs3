<?php
/**
 * サイト日別アクセス数のテストデータ生成
 */

namespace Hgs3\Models\Test;
use Hgs3\Models\Site\Good;
use Illuminate\Support\Facades\DB;

class SiteDailyAccess
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create site daily access test data.'.PHP_EOL;

        $sites = Site::getIds();

        $startDate = new \DateTime();
        $startDate->sub(new \DateInterval('P3M'));
        $endDate = new \DateTime();
        $di = new \DateInterval('P1D');

        $sql =<<< SQL
INSERT INTO site_daily_accesses (site_id, `date`, in_count, out_count, created_at, updated_at)
VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
ON DUPLICATE KEY UPDATE
  in_count = VALUES(`in_count`)
  , out_count = VALUES(`out_count`)
SQL;

        while ($startDate <= $endDate) {
            $date = $startDate->format('Ymd');

            foreach ($sites as $siteId) {
                DB::insert($sql, [$siteId, $date, rand(1, 999), rand(1, 999)]);
            }

            $startDate->add($di);
        }
    }
}