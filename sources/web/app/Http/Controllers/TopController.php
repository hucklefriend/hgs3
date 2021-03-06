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
        GlobalBack::clear();

        $notices = Orm\SystemNotice::select(['id', 'title', DB::raw('UNIX_TIMESTAMP(open_at) AS open_at_ts')])
            ->where('top_start_at', '<=', DB::raw('NOW()'))
            ->where('top_end_at', '>=', DB::raw('NOW()'))
            ->orderBy('open_at', 'DESC')
            ->get();

        $newInfo = NewInformation::get(time(), 10);

        return view('top', [
            'newInfo'    => $newInfo,
            'newInfoNum' => count($newInfo),
            'notices'    => $notices,
            'softNum'    => Soft::getNum(),
            'reviewNum'  => Review::getNum(),
            'siteNum'    => Site::getNum(),
            'userNum'    => User::getNum(),
            'newGames'   => Package::getNewGame()
        ]);
    }

    /**
     * トップページ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index2()
    {
        GlobalBack::clear();

        $notices = Orm\SystemNotice::select(['id', 'title', DB::raw('UNIX_TIMESTAMP(open_at) AS open_at_ts')])
            ->where('top_start_at', '<=', DB::raw('NOW()'))
            ->where('top_end_at', '>=', DB::raw('NOW()'))
            ->orderBy('open_at', 'DESC')
            ->get();

        $newInfo = NewInformation::get(time(), 10);

        return view('top2', [
            'newInfo'    => $newInfo,
            'newInfoNum' => count($newInfo),
            'notices'    => $notices,
            'softNum'    => Soft::getNum(),
            'reviewNum'  => Review::getNum(),
            'siteNum'    => Site::getNum(),
            'userNum'    => User::getNum(),
            'newGames'   => Package::getNewGame()
        ]);
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

    public function test()
    {
        return '';
    }

    public function test2()
    {
        $app = app();
        // 読み込み元のフォルダを指定
        $paths = [base_path('resources/views2')];

        // 新しい設定を適用
        $finder = new FileViewFinder($app['files'], $paths);
        View::setFinder($finder);

        return Response::json(NetworkLayout::load('title'));
    }
}
