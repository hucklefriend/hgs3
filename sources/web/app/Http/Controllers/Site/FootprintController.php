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
        $data = ['site' => $site];

        $pager = new LengthAwarePaginator([], Site\Footprint::getNumBySite($site->id), self::ITEMS_PER_PAGE);
        $pager->setPath('');

        $data['pager'] = $pager;

        $data['footprints'] = Site\Footprint::getBySite($site->id, self::ITEMS_PER_PAGE, ($pager->currentPage() - 1) * self::ITEMS_PER_PAGE);

        return view('site.footprint', $data);
    }

    /**
     * ユーザーの足跡
     *
     * @param User $user
     */
    public function user(User $user)
    {

    }
}
