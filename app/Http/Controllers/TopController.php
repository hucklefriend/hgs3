<?php
/**
 * トップページコントローラー
 */

namespace Hgs3\Http\Controllers;

use Hgs3\Http\GlobalBack;
use Hgs3\Models\Game\Package;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\Orm;
use Hgs3\Models\Review;
use Hgs3\Models\Site;
use Hgs3\Models\Timeline\NewInformation;
use Hgs3\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TopController extends Controller
{
    /**
     * トップページ
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        if (app()->isLocal()) {
            \Auth::loginUsingId(1, true);
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
     * @return Application|Factory|View
     */
    public function indexLogout(): Application|Factory|View
    {
        return $this->index();
    }

    /**
     * サイトマップ
     *
     * @return Application|Factory|View
     */
    public function sitemap(): Application|Factory|View
    {
        return view('sitemap');
    }

    /**
     * 新着情報
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function newInformation(Request $request): Application|Factory|View
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
     * @return Application|Factory|View
     */
    public function about(): Application|Factory|View
    {
        return view('about');
    }

    /**
     * プライバシーポリシー
     *
     * @return Application|Factory|View
     */
    public function privacy(): Application|Factory|View
    {
        return view('privacy');
    }

    /**
     * HGSのユーザーさんへ
     *
     * @return Application|Factory|View
     */
    public function hgs(): Application|Factory|View
    {
        return view('hgs');
    }
}
