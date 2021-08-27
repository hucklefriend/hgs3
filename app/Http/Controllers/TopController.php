<?php
/**
 * トップページコントローラー
 */

namespace Hgs3\Http\Controllers;

use Hgs3\Constants\PageId;
use Hgs3\Http\GlobalBack;
use Hgs3\Models\Game\Package;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\NetworkLayout;
use Hgs3\Models\Orm;
use Hgs3\Models\Review;
use Hgs3\Models\Site;
use Hgs3\Models\Timeline\NewInformation;
use Hgs3\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\View\FileViewFinder;

class TopController extends Controller
{
    /**
     * トップページ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (app()->isLocal()) {
            \Auth::loginUsingId(1);
        }

        GlobalBack::clear();

        return view('top', [
            'newInfo'    => NewInformation::get(time(), 10),
            'notices'    => Orm\SystemNotice::getTopPageData(),
            'softNum'    => Soft::getNum(),
            'reviewNum'  => Review::getNum(),
            'siteNum'    => Site::getNum(),
            'userNum'    => User::getNum(),
            'newGames'   => Package::getNewGame()
        ]);
    }

    /**
     * 認証切れでログアウトした先（トップページ）
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexLogout()
    {
        return $this->index();
    }

    /**
     * サイトマップ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sitemap()
    {
        return view('sitemap');
    }

    /**
     * 新着情報
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newInformation(Request $request)
    {
        GlobalBack::newInformation();

        $page = intval($request->query('page', 1));
        $items = NewInformation::getPage($page, 30);
        $num = NewInformation::getNum();

        return view('newInformation', [
            'newInfo' => new LengthAwarePaginator($items, $num, 30, $page, ['path' => $request->url()])
        ]);
    }

    /**
     * 当サイトについて
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        return view('about');
    }

    /**
     * プライバシーポリシー
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function privacy()
    {
        return view('privacy');
    }

    /**
     * HGSのユーザーさんへ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hgs()
    {
        return view('hgs');
    }
}
