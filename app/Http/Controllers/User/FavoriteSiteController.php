<?php
/**
 * お気に入りサイトコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Constants\Site\ApprovalStatus;
use Hgs3\Models\Orm;
use Hgs3\Models\User\FavoriteSite;
use Hgs3\Models\User;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteSiteController extends Controller
{
    /**
     * お気に入りサイト追加
     *
     * @param Request $request
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request, Orm\Site $site)
    {
        if ($site->approval_status != ApprovalStatus::OK) {
            return $this->forbidden(403);
        }

        if ($site->user_id != Auth::id()) {
            FavoriteSite::add(Auth::user(), $site);
        }

        return redirect()->back();
    }

    /**
     * お気に入りサイト削除
     *
     * @param Request $request
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request, Orm\Site $site)
    {
        FavoriteSite::remove(Auth::user(), $site);

        return redirect()->back();
    }
}
