<?php
/**
 * トップページコントローラー
 */

namespace Hgs3\Http\Controllers;

use Hgs3\Constants\UserRole;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Orm\NewInformation;
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

        $newInfo = NewInformation::getPager();
        $newInfoData = NewInformation::getPagerData($newInfo);

        return view('top', [
            'isLogin'     => Auth::check(),
            'isAdmin'     => UserRole::isAdmin(),
            'newInfo'     => $newInfo,
            'newInfoData' => $newInfoData,
        ]);
    }
}
