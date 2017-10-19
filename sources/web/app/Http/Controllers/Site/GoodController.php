<?php
/**
 * サイトへのいいねコントローラー
 */


namespace Hgs3\Http\Controllers\Site;

use Hgs3\Constants\UserRole;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Orm\Site;
use Hgs3\Models\Site\Good;
use Illuminate\Support\Facades\Auth;

class GoodController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'site');
    }

    /**
     * サイトへのいいね
     *
     * @param Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function good(Site $site)
    {
        $good = new Good();
        $good->good($site, Auth::user());

        return redirect()->back();
    }

    /**
     * サイトへのいいね取り消し
     *
     * @param Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Site $site)
    {
        $good = new Good();
        $good->cancelGood($site, Auth::user());

        return redirect()->back();
    }

    /**
     * いいね履歴
     *
     * @param Site $site
     */
    public function history(Site $site)
    {
        // いいね履歴は登録者本人しか確認できない
        // ただしH.G.N.管理人は除く
        if ($site->user_id != Auth::id() && !UserRole::isAdmin()) {
            return abort(403);
        }

        return view('site.goodHistory', [
            'site' => $site
        ]);
    }
}
