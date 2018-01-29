<?php
/**
 * お気に入りサイトコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Constants\Site\ApprovalStatus;
use Hgs3\Models\Orm;
use Hgs3\Models\User\FavoriteSite;
use Hgs3\Models\User;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteSiteController extends Controller
{
    /**
     * お気に入りサイトリスト
     *
     * @param string $showId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($showId)
    {
        $user = User::findByShowId($showId);
        if ($user == null) {
            return view('user.profile.notExist');
        }

        $isMyself = $user->id == Auth::id();
        $favoriteSites = FavoriteSite::get($user->id);
        $sites = Orm\Site::getHash(page_pluck($favoriteSites, 'site_id'));

        return view('user.profile.favoriteSite')->with([
            'user'          => $user,
            'isMyself'      => $isMyself,
            'favoriteSites' => $favoriteSites,
            'sites'         => $sites,
            'users'         => User::getHash(array_pluck($sites, 'user_id'))
        ]);
    }

    /**
     * お気に入りサイトリスト(自分)
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myself()
    {
        return $this->index(Auth::user());
    }

    /**
     * お気に入りサイト追加
     *
     * @param Request $request
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request, Orm\Site $site)
    {
        if ($site->approval_status != ApprovalStatus::OK) {
            return $this->forbidden(403);
        }

        if ($site->user_id != Auth::id()) {
            FavoriteSite::add(Auth::user(), $site);
        }

        return redirect()->back();
    }

    /**
     * お気に入りサイト削除
     *
     * @param Request $request
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request, Orm\Site $site)
    {
        FavoriteSite::remove(Auth::user(), $site);

        return redirect()->back();
    }
}
