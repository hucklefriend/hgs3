<?php
/**
 * サイトの足跡コントローラー
 */

namespace Hgs3\Http\Controllers\Site;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Hgs3\Models\Site;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class AccessController extends Controller
{
    /**
     * アクセスログ
     *
     * @param Orm\Site $site
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Orm\Site $site)
    {
        // サイトの管理人しか見られない
        if ($site->user_id != Auth::id()) {
            return $this->forbidden(['site_id' => $site->id]);
        }

        return view('site.access.index', [
            'site' => $site
        ]);
    }

    /**
     * サイトの足跡
     *
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function site(Orm\Site $site)
    {
        // サイトの管理人しか見られない
        if ($site->user_id != Auth::id()) {
            return $this->forbidden(['site_id' => $site->id]);
        }





        $data = ['site' => $site];

        $pager = new LengthAwarePaginator([], Site\Footprint::getNumBySite($site->id), self::ITEMS_PER_PAGE);
        $pager->setPath('');

        $data['pager'] = $pager;

        $data['footprints'] = Site\Footprint::getBySite($site->id, self::ITEMS_PER_PAGE, ($pager->currentPage() - 1) * self::ITEMS_PER_PAGE);
        $data['users'] = User::getHash(array_pluck($data['footprints'], 'user_id'));

        return view('site.footprint', $data);
    }

    /**
     * ユーザーの足跡
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function user(User $user)
    {
        $data = ['user' => $user];

        $pager = new LengthAwarePaginator([], Site\Footprint::getNumBySite($site->id), self::ITEMS_PER_PAGE);
        $pager->setPath('');

        $data['pager'] = $pager;

        $data['footprints'] = Site\Footprint::getBySite($site->id, self::ITEMS_PER_PAGE, ($pager->currentPage() - 1) * self::ITEMS_PER_PAGE);
        $data['sites'] = User::getHash(array_pluck($data['footprints'], 'site_id'));

        return view('user.site.footprint', $data);
    }

    /**
     * 日単位のアクセス数
     *
     * @param Orm\Site $site
     */
    public function daily(Orm\Site $site)
    {
        $now = new \DateTime();
        $year = intval(Input::get('y'));
        $month = intval(Input::get('m'));
        if ($year === null || $month === null) {
            $year = $now->format('Y');
            $month = $now->format('m');
        }

        $years = [];
        $maxYear = intval($now->format('Y'));
        for ($y = 2017; $y <= $maxYear; $y++) {
            $years[$y] = $y;
        }

        $data['daily'] = Site\Footprint::getDailyAccess($site, $year, $month);
        $data['maxDays'] = intval($now->fomat('t'));
        $data['site'] = $site;

        return view('user.site.dailyAccess', $data);
    }
}
