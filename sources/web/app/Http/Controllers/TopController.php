<?php
/**
 * トップページコントローラー
 */

namespace Hgs3\Http\Controllers;

use Hgs3\Constants\UserRole;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TopController extends Controller
{
    /**
     * トップページ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (Auth::check()) {
            // ログイン中ならマイページに飛ばす
            return redirect('mypage');
        }

        return view('top', [
            'isLogin' => Auth::check(),
            'isAdmin' => UserRole::isAdmin()
        ]);
    }
}
