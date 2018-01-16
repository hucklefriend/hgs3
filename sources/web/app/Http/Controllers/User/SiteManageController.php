<?php
/**
 * サイト管理コントローラー
 */


namespace Hgs3\Http\Controllers\User;

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

class SiteManageController extends Controller
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
        return view('user.profile.site', [
            'user'     => Auth::user(),
            'isMyself' => true,
            'sites'    => Site::getUserSites(Auth::id())
        ]);
    }

    /**
     * サイト追加画面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        // サイト登録可能数チェック
        if (Site::isMax(Auth::id())) {
            return abort(403);
        }

        return view('user.siteManage.add', [
            'isTakeOver' => false,
            'softs'      => Orm\GameSoft::getPhoneticTypeHash(),
            'site'       => new Orm\Site([
                'main_contents_id'          => MainContents::WALKTHROUGH,
                'rate'                      => Rate::ALL,
                'gender'                    => Gender::NONE,
                'list_banner_upload_flag'   => 0,
                'detail_banner_upload_flag' => 0
            ])
        ]);
    }

    /**
     * 引き継ぐサイトを選択
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function takeOverSelect()
    {
        return view('user.siteManage.takeOverSelect', [
            'hgs2Sites' => Site\TakeOver::getHgs2Sites(Auth::user())
        ]);
    }

    /**
     * 引き継ぎ登録画面
     *
     * @param $hgs2SiteId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function takeOver($hgs2SiteId)
    {
        // サイト登録可能数チェック
        if (Site::isMax(Auth::id())) {
            return abort(403);
        }

        // 本人しか引き継げない
        if (!Site\TakeOver::isOwner(Auth::user(), $hgs2SiteId)) {
            return abort(403);
        }

        return view('user.siteManage.add', [
            'isTakeOver' => true,
            'softs'      => Orm\GameSoft::getPhoneticTypeHash(),
            'site'       => Site\TakeOver::getHgs2Site(Auth::user(), $hgs2SiteId)
        ]);
    }

    /**
     * サイト追加
     *
     * @param SiteRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function insert(SiteRequest $request)
    {
        // サイト登録可能数チェック
        if (Site::isMax(Auth::id())) {
            return abort(403);
        }

        $site = new Orm\Site;

        // 引き継ぎの場合は登録日と、アクセスカウントをコピー
        $hgs2SiteId = $request->get('hgs2_site_id', 0);
        if ($hgs2SiteId > 0) {
            $hgs2Site = Site\TakeOver::getHgs2Site(Auth::user(), $hgs2SiteId);
            if ($hgs2Site != null) {
                $site->in_count = $hgs2Site->in;
                $site->out_count = $hgs2Site->out;
                $site->registered_timestamp = $hgs2Site->registered_date;
            }
        } else {
            $site->in_count = 0;
            $site->out_count = 0;
            $site->registered_timestamp = time();
        }

        $this->setRequestData($site, $request);
        $site->list_banner_upload_flag = $request->get('list_banner_upload_flag');
        $site->list_banner_url = $request->get('list_banner_url');
        $site->detail_banner_upload_flag = $request->get('detail_banner_upload_flag');
        $site->detail_banner_url = $request->get('detail_banner_url');
        $site->open_type = 0;
        $site->good_num = 0;
        $site->max_good_num = 0;
        $site->bad_num = 0;
        $site->updated_timestamp = time();

        $listBanner = $request->file('list_banner_upload');
        $detailBanner = $request->file('detail_banner_upload');

        if (!Site::save(Auth::user(), $site, $listBanner, $detailBanner)) {
            session(['se' => 1]);
            return redirect()->back()->withInput();
        }

        session(['a' => 1]);

        return redirect('site/detail/' . $site->id);
    }

    /**
     * 編集画面
     *
     * @param Orm\Site $site
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Orm\Site $site)
    {
        // 本人しか更新できない
        if ($site->user_id != Auth::id()) {
            return abort(403);
        }

        // バナーのフラグを-1（変更しない）にしとく
        $site->list_banner_upload_flag = -1;
        $site->detail_banner_upload_flag = -1;

        return view('user.siteManage.edit', [
            'softs' => Orm\GameSoft::getPhoneticTypeHash(),
            'site'  => $site
        ]);
    }

    /**
     * データ更新
     *
     * @param SiteRequest $request
     * @param Orm\Site $site
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update(SiteRequest $request, Orm\Site $site)
    {
        // 本人しか更新できない
        if ($site->user_id != Auth::id()) {
            return abort(403);
        }

        $this->setRequestData($site, $request);
        if ($request->get('list_banner_upload_flag') != -1) {
            $site->list_banner_upload_flag = $request->get('list_banner_upload_flag');
            $site->list_banner_url = $request->get('list_banner_url');
        }
        if ($request->get('detail_banner_upload_flag') != -1) {
            $site->detail_banner_upload_flag = $request->get('detail_banner_upload_flag');
            $site->detail_banner_url = $request->get('detail_banner_url');
        }
        $site->updated_timestamp = time();

        $listBanner = $request->file('list_banner_upload');
        $detailBanner = $request->file('detail_banner_upload');

        if (!Site::save(Auth::user(), $site, $listBanner, $detailBanner)) {
            session(['se' => 1]);
            return redirect()->back()->withInput();
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
        $site->presentation = $request->get('presentation', '');
        $site->main_contents_id = intval($request->get('main_contents', MainContents::OTHER));
        $site->rate = intval($request->get('rate',Rate::ALL));
        $site->gender = intval($request->get('gender', Gender::NONE));
        $site->handle_soft = $request->get('handle_soft');
    }

    /**
     * 削除
     *
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function delete(Orm\Site $site)
    {
        // 本人しか削除できない
        if ($site->user_id != Auth::id()) {
            return abort(403);
        }

        Site::delete($site);

        return redirect('user/profile/' . Auth::id() . '/site');
    }
}
