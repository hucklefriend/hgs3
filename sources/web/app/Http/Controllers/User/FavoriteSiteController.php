<?php
/**
 * お気に入りサイトコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Models\Orm\GameSoft;
use Hgs3\Models\Orm\UserFavoriteSite;
use Hgs3\Models\Site;
use Hgs3\Models\User\FavoriteSite;
use Hgs3\User;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteSiteController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'game');
    }

    /**
     * お気に入りサイトリスト
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $user)
    {
        $isMyself = $user->id == Auth::id();
        $fav = UserFavoriteSite::where('user_id', $user->id)->get();



        return view('user.site.favorite')->with([
            'user'     => $user,
            'isMyself' => $isMyself,
            'favSites' => $fav,
            'sites'    => GameSoft::getNameHash(array_pluck($fav->toArray(), 'site_id'))
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
        $siteId = $request->get('site_id');
        if ($siteId != null) {
            $fav = new FavoriteSite();
            $fav->add(Auth::id(), $siteId);
        }

        return redirect()->back();
    }

    /**
     * お気に入りサイト削除
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        $siteId = $request->get('site_id');
        if ($siteId != null) {
            $fav = new FavoriteSite();
            $fav->remove(Auth::id(), $siteId);
        }

        return redirect()->back();
    }
}
