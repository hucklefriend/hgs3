<?php
/**
 * サイトコントローラー
 */


namespace Hgs3\Http\Controllers\Site;

use Hgs3\Constants\Site\Gender;
use Hgs3\Constants\Site\MainContents;
use Hgs3\Constants\Site\Rate;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Review\SiteRequest;
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

        // TODO 足跡
        $footprint = [];

        $admin = User::find($site->user_id);

        return view('site.detail')->with([
            'site'          => $site,
            'handleGames'   => implode('、', $handleGames),
            'admin'         => User::find($site->user_id),
            'isWebMaster'   => $admin->id == Auth::id(),
            'isLogin'       => $isLogin,
            'isFavorite'    => $isFavorite,
            'footprint'     => $footprint,
            'favoriteUsers' => $favoriteUsers,
            'users'         => User::getNameHash(array_pluck($favoriteUsers->toArray(), 'user_id'))
        ]);
    }

    /**
     * サイト追加画面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        // TODO サイト登録可能数チェック


        return view('site.add', [
            'games' => Game::getPhoneticTypeHash(),
            'site'  => new Site([
                'main_contents' => MainContents::WALKTHROUGH,
                'rate'          => Rate::ALL,
                'gender'        => Gender::NONE
            ])
        ]);
    }

    /**
     * サイト追加
     *
     * @param SiteRequest $request
     * @return $this
     */
    public function store(SiteRequest $request)
    {
        $site = new Site;

        $site->user_id = Auth::id();
        $site->name = $request->get('name') ?? '';
        $site->url = $request->get('url') ?? '';
        $site->banner_url = $request->get('banner_url') ?? '';
        $site->presentation = $request->get('presentation') ?? '';
        $site->main_contents_id = intval($request->get('main_contents') ?? 0);
        $site->rate = intval($request->get('rate') ?? 1);
        $site->gender = intval($request->get('gender') ?? 1);
        $site->open_type = 0;
        $site->in_count = 0;
        $site->out_count = 0;
        $site->good_count = 0;
        $site->bad_count = 0;
        $site->registered_timestamp = time();
        $site->updated_timestamp = 0;

        $siteId = $site->saveWithHandleGame($request->get('handle_game') ?? '');
        if ($siteId === false) {
            // TODO エラー
        }

        return view('user.site.add_complete')->with([
            'site_id' => $siteId
        ]);
    }
}
