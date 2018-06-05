<?php
/**
 * サイトへのいいねコントローラー
 */


namespace Hgs3\Http\Controllers\Site;

use Hgs3\Constants\UserRole;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Orm;
use Hgs3\Models\Site\Good;
use Illuminate\Support\Facades\Auth;

class GoodController extends Controller
{
    /**
     * サイトへのいいね
     *
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function good(Orm\Site $site)
    {
        $good = new Good();
        $good->good($site, Auth::user());

        return redirect()->back();
    }

    /**
     * サイトへのいいね取り消し
     *
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function cancel(Orm\Site $site)
    {
        $good = new Good();
        $good->cancelGood($site, Auth::user());

        return redirect()->back();
    }
}
