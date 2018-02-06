<?php
/**
 * サイトのアクセス数
 */

namespace Hgs3\Models\Site;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;

class AccessCount
{
    /**
     * 月間アクセス数を取得
     *
     * @param Orm\Site $site
     * @param \DateTime $now
     * @return array
     */
    public static function getMonthly(Orm\Site $site, \DateTime $now)
    {
        $accesses = Orm\SiteDailyAccess::select(['in_count', 'out_count', DB::raw('DATE_FORMAT(`date`, "%e") AS day')])
            ->where('site_id', $site->id)
            ->whereBetween('date', [$now->format('Y-m-01'), $now->format('Y-m-t')])
            ->get();

        // 日でハッシュ化
        $hash = [];
        foreach ($accesses as $access) {
            $obj = new \stdClass;
            $obj->in = $access->in_count;
            $obj->out = $access->out_count;
            $hash[$access->day] = $obj;
        }

        unset($accesses);

        return $hash;
    }
}