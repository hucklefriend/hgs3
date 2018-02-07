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
     * @param \DateTime $date
     * @return array
     */
    public static function getMonthly(Orm\Site $site, \DateTime $date)
    {
        $ym = $date->format('Ym');

        $accesses = Orm\SiteDailyAccess::select(['in_count', 'out_count', 'date'])
            ->where('site_id', $site->id)
            ->whereBetween('date', [$ym . '01', $ym . sprintf('%02d', $date->format('t'))])
            ->get();

        // 日でハッシュ化
        $hash = [];
        foreach ($accesses as $access) {
            $obj = new \stdClass;
            $obj->in = $access->in_count;
            $obj->out = $access->out_count;
            $obj->date = $access->date;
            $hash[$access->date % 100] = $obj;
        }

        unset($accesses);

        return $hash;
    }
}