<?php
/**
 * ユーザーのサイトコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Requests\User\Site\AddRequest;
use Hgs3\Http\Requests\User\Site\UpdateRequest;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\Site;
use Hgs3\User;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'site');
    }

    /**
     * サイトページ
     *
     * @param User $user
     * @return $this|SiteController
     */
    public function index(User $user)
    {
        // ログインユーザー本人の場合は、自身のサイトページへ
        if ($user->id == Auth::id()) {
            return $this->myself();
        }

        return view('user.site.index')->with([
        ]);
    }

    /**
     * 自身の管理サイトを表示
     *
     * @return $this
     */
    public function myself()
    {
        return view('user.site.myself')->with([
            'sites' => Site::where('user_id', Auth::id())->get()
        ]);
    }
}
