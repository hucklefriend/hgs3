<?php
/**
 * サイトの足跡コントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Hgs3\Models\Site;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class SiteAccessController extends Controller
{
    /**
     * アクセスログ
     *
     * @param Orm\Site $site
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Orm\Site $site)
    {
        // サイトの管理人しか見られない
        if ($site->user_id != Auth::id()) {
            return $this->forbidden(['site_id' => $site->id]);
        }

        $ym = Input::get('ym');
        if ($ym == null) {
            $date = new \DateTime();
        } else {
            try {
                $date = new \DateTime($ym . '-01');
            } catch (\Exception $e) {
                $date = new \DateTime();
            }
        }

        $prev = clone $date;
        $prev->sub(new \DateInterval('P1M'));
        $next = clone $date;
        $next->add(new \DateInterval('P1M'));

        $nearlyFootprints = Site\Footprint::getBySite($site->id, 5, 0);

        return view('site.access.index', [
            'site'     => $site,
            'date'     => $date,
            'maxDay'   => $date->format('t'),
            'prev'     => $prev,
            'next'     => $next,
            'accesses' => Site\AccessCount::getMonthly($site, $date),
            'nearlyFootprints' => $nearlyFootprints,
            'footprintUsers'   => User::getHash(array_pluck($nearlyFootprints, 'user_id')),
            'useDatePicker'    => true
        ]);
    }

    public function dailyFootprint(Orm\Site $site, $date)
    {

    }
}
