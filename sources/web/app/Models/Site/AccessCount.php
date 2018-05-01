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
        $today = new \DateTIme();
        $maxDate = intval($date->format('t'));
        $todayYmd = intval($today->format('Ymd'));
        $weekday = $date->format('w');

        $accesses = Orm\SiteDailyAccess::select(['in_count', 'out_count', 'date', DB::raw('MOD(date, 100) AS day')])
            ->where('site_id', $site->id)
            ->whereBetween('date', [$ym . '01', $ym . $date->format('t')])
            ->get()
            ->keyBy('day');

        $data = [];

        // 先月の余白
        for ($prevMonth = 0; $prevMonth < $weekday; $prevMonth++) {
            $obj = new \stdClass;
            $obj->disable = true;
            $obj->otherMonth = true;
            $data[] = $obj;
        }

        for ($day = 1; $day <= $maxDate; $day++) {
            $obj = new \stdClass;
            $obj->day = $day;
            $obj->otherMonth = false;
            if (isset($accesses[$day])) {
                if ($accesses[$day]->date <= $todayYmd) {
                    $obj->disable = false;
                    $obj->in = $accesses[$day]->in_count;
                    $obj->out = $accesses[$day]->out_count;
                    $obj->date = $accesses[$day]->date;
                } else {
                    $obj->disable = true;
                }
            } else {
                $obj->disable = sprintf('%s%02d', $ym, $day) > $todayYmd;
                $obj->in = 0;
                $obj->out = 0;
            }

            $data[] = $obj;
        }

        // 今月末
        for ($weekday = date('w', strtotime($date->format('Y-m-t'))); $weekday < 6; $weekday++) {
            $obj = new \stdClass;
            $obj->disable = true;
            $obj->otherMonth = true;
            $data[] = $obj;
        }

        unset($accesses);

        return $data;
    }
}