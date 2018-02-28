<?php
/**
 * 退会コントローラー
 */

namespace Hgs3\Http\Controllers\Account;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Account\PasswordResetRequest;
use Hgs3\Http\Requests\Account\MailAuthRequest;
use Hgs3\Models\Account\PasswordReset;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LeaveController extends Controller
{
    /**
     * 退会
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('account.leave');
    }

    /**
     * 退会処理
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function leave()
    {
        if (Auth::id() == 1) {
            // 管理人は退会不可
            return redirect()->route('トップ');
        }

        $user = Auth::user();
        $user->leave();

        Auth::logout();

        return redirect()->route('トップ');
    }
}
