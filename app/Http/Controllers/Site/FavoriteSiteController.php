<?php
/**
 * お気に入りサイトコントローラー
 */

namespace Hgs3\Http\Controllers\Site;

use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Hgs3\Http\Controllers\Controller;

class FavoriteSiteController extends Controller
{
    /**
     * お気に入りサイトに登録しているユーザー
     *
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Orm\Site $site)
    {
        $pager = Orm\UserFavoriteSite::where('site_id', $site->id)
            ->paginate(30);

        return view('site.favorite.index')->with([
            'site'  => $site,
            'pager' => $pager,
            'users' => User::getNameHash(array_pluck($pager->items(), 'user_id'))
        ]);
    }
}
