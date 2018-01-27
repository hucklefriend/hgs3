<?php
/**
 * サイトコントローラー
 */


namespace Hgs3\Http\Controllers\Site;

use Hgs3\Constants\Site\ApprovalStatus;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Site;
use Hgs3\Models\Site\Good;
use Hgs3\Models\Orm;
use Hgs3\Models\User\FavoriteSite;
use Hgs3\Models\User;
use Hgs3\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class SiteController extends Controller
{
    /**
     * トップ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($time = null)
    {
        if ($time === null) {
            $time = time();
        }

        return view('site.index', [
            'timeline' => Timeline\Site::get($time, 20)
        ]);
    }

    public function newArrival()
    {

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
        $isWebMaster = $site->user_id == Auth::id();

        // アクセスできるか
        if ($site->approval_status != ApprovalStatus::OK) {
            if (!$isWebMaster) {
                return view('site.private');
            }
        }

        $data = ['site' => $site];

        $data['handleSofts'] = Site::getSoftWithOriginalPackage($site->id);

        // 更新履歴
        $data['updateHistories'] = Orm\SiteUpdateHistory::where('site_id', $site->id)
            ->orderBy('site_updated_at', 'DESC')
            ->take(3)
            ->get();

        $isLogin = Auth::check();
        $data['isFavorite'] = false;
        $data['isGood'] = false;
        if ($isLogin) {
            $data['isFavorite'] = FavoriteSite::isFavorite(Auth::id(), $site->id);
            $data['isGood'] = Good::isGood($site, Auth::user());
        }

        $data['webMaster'] = User::find($site->user_id);
        $data['isWebMaster'] = $isWebMaster;

        if ($request->session()->pull('a') != null) {
            $data['defaultMessage'] = '';
        }

        if ($request->session()->pull('u') != null) {
            $data['defaultMessage'] = '';
        }

        return view('site.detail', $data);
    }

    /**
     * サイトへGO
     *
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function go(Orm\Site $site)
    {
        // TODO 終了処理ミドルウェアを使って、リダイレクト後に処理させる
        if (Auth::check()) {
            if (Auth::user()->footprint == 1) {
                Site\Footprint::add($site, Auth::user());
            } else {
                Site\Footprint::add($site, null);
            }
        } else {
            Site\Footprint::add($site, null);
        }

        Site::access($site);

        return redirect($site->url);
    }
}
