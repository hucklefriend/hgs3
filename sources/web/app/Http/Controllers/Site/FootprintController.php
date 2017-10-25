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

class FootprintController extends Controller
{
    const ITEMS_PER_PAGE = 15;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'site');
    }

    /**
     * サイトの足跡
     *
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function site(Orm\Site $site)
    {
        if ($site->user_id != Auth::id() && !is_admin()) {
            return abort(403);
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
}
