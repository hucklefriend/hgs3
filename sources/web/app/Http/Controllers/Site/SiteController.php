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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class SiteController extends Controller
{
    /**
     * トップ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index()
    {
        $newArrivals = Site\NewArrival::get(5);
        $updateArrivals = Site\UpdateArrival::get(5);

        $webmasterIds = array_merge(
            array_pluck($newArrivals, 'user_id'),
            array_pluck($updateArrivals, 'user_id')
        );

        return view('site.index', [
            'newArrivals'    => $newArrivals,
            'updateArrivals' => $updateArrivals,
            'webmasters'     => User::getHash($webmasterIds),
            'timelines'      => Timeline\Site::get(time(), 3)
        ]);
    }

    /**
     * ゲーム指定なしで検索
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $mainContents = Input::get('mc', []);
        $targetGender = Input::get('g', []);
        $rate = Input::get('r', []);

        $data = Site::search(null, $mainContents, $targetGender, $rate, 20);
        $data['mc'] = $mainContents;
        $data['g'] = $targetGender;
        $data['r'] = $rate;

        return view('site.search', $data);
    }

    /**
     * タイムライン
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function timeline($time = null)
    {
        if ($time === null) {
            $time = time();
        }

        return view('site.timeline', [
            'timelines' => Timeline\Site::get($time, 20)
        ]);
    }

    /**
     * 新着サイト一覧
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function newArrival()
    {
        $newArrivals = Site\NewArrival::getPage(20);
        $sites = Orm\Site::getHash(page_pluck($newArrivals, 'site_id'));
        $users = User::getHash(array_pluck($sites, 'user_id'));

        return view('site.newArrival', [
            'newArrivals' => $newArrivals,
            'sites'       => $sites,
            'users'       => $users
        ]);
    }

    /**
     * 更新サイト一覧
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function updateArrival()
    {
        $updateArrivals = Site\UpdateArrival::getPage(20);
        $sites = Orm\Site::getHash(page_pluck($updateArrivals, 'site_id'));
        $users = User::getHash(array_pluck($sites, 'user_id'));

        return view('site.updateArrival', [
            'updateArrivals' => $updateArrivals,
            'sites'          => $sites,
            'users'          => $users
        ]);
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
     * サイト更新履歴
     *
     * @param Orm\Site $site
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateHistory(Orm\Site $site)
    {
        $updateHistories = Orm\SiteUpdateHistory::where('site_id', $site->id)
            ->where('site_updated_at', '<=', DB::raw('CURDATE()'))
            ->orderBy('site_updated_at', 'DESC')
            ->paginate(20);

        return view('site.updateHistory', [
            'site'            => $site,
            'updateHistories' => $updateHistories
        ]);
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

        $data['favoriteNum'] = $site->getFavoriteNum();
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

        $data['favoriteHash'] = [];
        if (Auth::check()) {

            $data['favoriteHash'] = User\FavoriteSoft::getHash(Auth::id());
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
        // 足跡を残す処理は、GoToSiteミドルウェアに
        return redirect($site->url);
    }
}
