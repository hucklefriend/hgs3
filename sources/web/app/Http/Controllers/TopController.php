<?php
/**
 * トップページコントローラー
 */

namespace Hgs3\Http\Controllers;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;

class TopController extends Controller
{
    /**
     * トップページ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $newInfo = Orm\NewInformation::select([
            'soft_id', 'site_id', 'text_type',
            DB::raw('DATE_FORMAT(open_at, "%Y-%m-%d %H:%i") AS open_at')
        ])
            ->orderBy('open_at', 'DESC')
            ->take(5)
            ->get();

        $gameHash = Orm\GameSoft::getNameHash($newInfo->pluck('soft_id')->toArray());
        $siteHash = Orm\Site::getNameHash($newInfo->pluck('site_id')->toArray());

        $notices = Orm\SystemNotice::select(array('id', 'title', DB::raw('DATE_FORMAT(open_at, "%Y-%m-%d %H:%i") AS open_at_str')))
            ->where('open_at', '<=', DB::raw('NOW()'))
            ->where('close_at', '>=', DB::raw('NOW()'))
            ->orderBy('open_at', 'DESC')
            ->take(5)
            ->get();

        return view('top', [
            'newInfo'  => $newInfo,
            'gameHash' => $gameHash,
            'siteHash' => $siteHash,
            'notices'  => $notices
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
    public function newInformation()
    {
        $newInfo = Orm\NewInformation::orderBy('open_at', 'DESC')
            ->paginate(30);
        $gameHash = Orm\GameSoft::getNameHash(array_pluck($newInfo->items(), 'game_id'));
        $siteHash = Orm\Site::getNameHash(array_pluck($newInfo->items(), 'site_id'));

        return view('newInformation', [
            'newInfo'  => $newInfo,
            'gameHash' => $gameHash,
            'siteHash' => $siteHash
        ]);
    }
}
