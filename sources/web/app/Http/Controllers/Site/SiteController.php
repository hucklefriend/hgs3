<?php
/**
 * サイトコントローラー
 */


namespace Hgs3\Http\Controllers\Site;

use Hgs3\Constants\Site\Gender;
use Hgs3\Constants\Site\MainContents;
use Hgs3\Constants\Site\Rate;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Site\SiteRequest;
use Hgs3\Models\Site;
use Hgs3\Models\Site\Good;
use Hgs3\Models\Orm;
use Hgs3\Models\User\FavoriteSite;
use Hgs3\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('site.index', Site::getIndexData());
    }

    /**
     * 指定ゲームで検索
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function soft(Orm\GameSoft $soft)
    {
        $mainContents = intval(Input::get('mc', 0));
        $targetGender = intval(Input::get('tg', 0));
        $rate = intval(Input::get('r', 0));

        return view('site.soft', Site::search($soft, $mainContents, $targetGender, $rate, 20));
    }

    /**
     * 詳細表示
     *
     * @param Request $request
     * @param Orm\Site $site
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request, Orm\Site $site)
    {
        $data = ['site' => $site];

        $data['handleSofts'] = Site::getSoftWithOriginalPackage($site->id);

        $isLogin = Auth::check();
        $data['isFavorite'] = false;
        $data['isGood'] = false;
        if ($isLogin) {
            $data['isFavorite'] = FavoriteSite::isFavorite(Auth::id(), $site->id);
            $data['isGood'] = Good::isGood($site, Auth::user());
        }

        $data['favoriteUsers'] = FavoriteSite::getOldUsers($site->id);

        $data['webMaster'] = User::find($site->user_id);
        $data['isWebMaster'] = $data['webMaster']->id == Auth::id();

        // TODO 足跡
        $data['footprint'] = [];

        $data['users'] = User::getNameHash(array_pluck($data['favoriteUsers']->toArray(), 'user_id'));
        $data['csrfToken'] = csrf_token();

        if ($request->session()->pull('a') != null) {
            $data['defaultMessage'] = '';
        }

        if ($request->session()->pull('u') != null) {
            $data['defaultMessage'] = '';
        }

        return view('site.detail', $data);
    }

    /**
     * サイト追加画面
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        // TODO サイト登録可能数チェック

        return view('site.add', [
            'softs' => Orm\GameSoft::getPhoneticTypeHash(),
            'site'  => new Orm\Site([
                'main_contents' => MainContents::WALKTHROUGH,
                'rate'          => Rate::ALL,
                'gender'        => Gender::NONE
            ]),
            'handleGames' => ''
        ]);
    }

    /**
     * サイト追加
     *
     * @param SiteRequest $request
     * @return $this
     */
    public function insert(SiteRequest $request)
    {
        $site = new Orm\Site;

        $this->setRequestData($site, $request);
        $site->open_type = 0;
        $site->in_count = 0;
        $site->out_count = 0;
        $site->good_num = 0;
        $site->max_good_num = 0;
        $site->bad_num = 0;
        $site->registered_timestamp = time();
        $site->updated_timestamp = 0;

        $handleSoft = $request->get('handle_soft', '');
        $listBanner = $request->file('list_banner_upload');
        $detailBanner = $request->file('detail_banner_upload');

        if (!Site::save(Auth::user(), $site, $handleSoft, $listBanner, $detailBanner)) {
            session(['se' => 1]);
            return redirect()->back()->withInput();
        }

        \ChromePhp::info('test');

        session(['a' => 1]);

        return redirect('site/detail/' . $site->id);
    }

    /**
     * 編集画面
     *
     * @param Request $request
     * @param Orm\Site $site
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, Orm\Site $site)
    {
        return view('site.edit', [
            'softs' => Orm\GameSoft::getPhoneticTypeHash(),
            'site'  => $site
        ]);
    }

    /**
     * データ更新
     *
     * @param SiteRequest $request
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SiteRequest $request, Orm\Site $site)
    {
        $this->setRequestData($site, $request);
        $site->updated_timestamp = time();

        if (!Site::save(Auth::user(), $site, $request->get('handle_game', ''))) {
            session(['se' => 1]);
            return 'error';//redirect()->back()->withInput();
        }

        session(['u' => 1]);

        return redirect('site/detail/' . $site->id);
    }

    /**
     * リクエストの値をO/Rマッパーにセット
     *
     * @param Orm\Site $site
     * @param SiteRequest $request
     */
    private function setRequestData(Orm\Site $site, SiteRequest $request)
    {
        $site->user_id = Auth::id();
        $site->name = $request->get('name', '');
        $site->url = $request->get('url', '');
        $site->list_banner_upload_flag = $request->get('list_banner_upload_flag');
        $site->list_banner_url = $request->get('list_banner_url');
        $site->detail_banner_upload_flag = $request->get('detail_banner_upload_flag');
        $site->detail_banner_url = $request->get('detail_banner_url');
        $site->presentation = $request->get('presentation', '');
        $site->main_contents_id = intval($request->get('main_contents', MainContents::OTHER));
        $site->rate = intval($request->get('rate',Rate::ALL));
        $site->gender = intval($request->get('gender', Gender::NONE));
        $site->handle_soft = $request->get('handle_soft');
    }

    /**
     * サイトへGO
     *
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function go(Orm\Site $site)
    {
        if (Auth::check()) {
            if (Auth::user()->footprint == 1) {
                Site\Footprint::add($site, Auth::user());
            } else {
                Site\Footprint::add($site, null);
            }
        } else {
            Site\Footprint::add($site, null);
        }

        return redirect($site->url);
    }
}
