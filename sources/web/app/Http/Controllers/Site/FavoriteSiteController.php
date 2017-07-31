<?php
/**
 * お気に入りサイトコントローラー
 */

namespace Hgs3\Http\Controllers\Site;

use Hgs3\Models\Orm\Site;
use Hgs3\Models\Orm\UserFavoriteSite;
use Hgs3\User;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteSiteController extends Controller
{
    /**
     * お気に入りサイトに登録しているユーザー
     *
     * @param Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Site $site)
    {
        $pager = UserFavoriteSite::where('site_id', $site->id)
            ->paginate(30);

        return view('site.favorite.index')->with([
            'site'  => $site,
            'pager' => $pager,
            'users' => User::getNameHash(array_pluck($pager->items(), 'user_id'))
        ]);
    }
}
