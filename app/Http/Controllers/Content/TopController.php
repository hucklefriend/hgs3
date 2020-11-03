<?php
/**
 * トップページコントローラー
 */

namespace Hgs3\Http\Controllers\Content;

use Hgs3\Constants\PageId;
use Hgs3\Http\GlobalBack;
use Hgs3\Models\Game\Package;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\Orm;
use Hgs3\Models\Review;
use Hgs3\Models\Site;
use Hgs3\Models\Timeline\NewInformation;
use Hgs3\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TopController extends Controller
{
    /**
     * サイトマップ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sitemap()
    {
        return $this->result('title', 'サイトマップ', 'site-map');
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
        return $this->result('title', '当サイトについて', 'about');
    }

    /**
     * プライバシーポリシー
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function privacy()
    {
        return $this->result('title', 'プライバシーポリシー', 'privacy');
    }

    /**
     * HGSのユーザーさんへ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hgs()
    {
        return $this->result('title', 'H.G.S.のユーザーさんへ', 'hgs');
    }
}
