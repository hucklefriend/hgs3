<?php
/**
 * サイトコントローラー
 */


namespace Hgs3\Http\Controllers\Site;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Site\Searcher;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\Site;
use Hgs3\Models\User\FavoriteSite;
use Hgs3\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class SiteController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'site');
    }

    /**
     * トップ
     *
     * @return $this
     */
    public function index()
    {
        $site = new \Hgs3\Models\Site();

        // 新着サイト
        $data['newcomer'] = $site->getNewcomer();

        // 更新サイト
        $data['updated'] = $site->getLatestUpdate();

        // 人気サイト
        $data['good'] = $site->getGoodRanking();

        // アクセス数
        $data['access'] = $site->getAccessRanking();

        $userIds = array_merge(
            $data['newcomer']->pluck('user_id')->toArray(),
            $data['updated']->pluck('user_id')->toArray(),
            $data['newcomer']->pluck('user_id')->toArray(),
            $data['access']->pluck('user_id')->toArray()
        );

        $data['users'] = User::getNameHash($userIds);

        return view('site.index', $data);
    }

    /**
     * 指定ゲームで検索
     *
     * @param Game $game
     * @return $this
     */
    public function game(Game $game)
    {
        $mainContents = intval(Input::get('mc', 0));
        $targetGender = intval(Input::get('tg', 0));
        $rate = intval(Input::get('r', 0));
        $searcher = new Searcher();
        $data = $searcher->search($game->id, $mainContents, $targetGender, $rate, 20);
        $data['game'] = $game;

        return view('site.search.game')->with($data);
    }

    /**
     * 詳細表示
     *
     * @param Site $site
     * @return $this
     */
    public function detail(Site $site)
    {
        $handleGames = [];

        $gameIds = $site->getHandleGames();
        if (!empty($gameIds)) {
            $handleGames = Game::getNameHash($gameIds);
        }

        $fs = new FavoriteSite;

        $isLogin = Auth::check();
        $isFavorite = false;
        if ($isLogin) {
            $isFavorite = $fs->isFavorite(Auth::id(), $site->id);
        }

        $favoriteUsers = $fs->getOldUsers($site->id);

        $footprint = [];

        $admin = User::find($site->user_id);

        return view('site.detail')->with([
            'site'          => $site,
            'handleGames'   => implode('、', $handleGames),
            'admin'         => User::find($site->user_id),
            'isAdmin'       => $admin->id == Auth::id(),
            'isLogin'       => $isLogin,
            'isFavorite'    => $isFavorite,
            'footprint'     => $footprint,
            'favoriteUsers' => $favoriteUsers,
            'users'         => User::getNameHash(array_pluck($favoriteUsers->toArray(), 'user_id'))
        ]);
    }

    public function good()
    {

    }

    public function injustice()
    {

    }

    /**
     * サイト遷移
     *
     * @param Site $site
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function go(Site $site)
    {
        // TODO アクセスログに保存

        return redirect($site->url);
    }
}
