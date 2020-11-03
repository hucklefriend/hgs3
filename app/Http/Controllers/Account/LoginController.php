<?php
/**
 * ログインコントローラー
 */

namespace Hgs3\Http\Controllers\Account;

use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Hgs3\Http\Requests\AuthenticateRequest;

class LoginController extends Controller
{
    /**
     * ログイン画面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * 認証
     *
     * @param AuthenticateRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function authenticate(AuthenticateRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
            // 認証に成功した
            return redirect()->intended('mypage');
        } else {
            return back()->withInput()->withErrors(['login_error' => 'ログインに失敗しました。メールアドレスかパスワードが間違っている可能性があります。']);
        }
    }

    /**
     * ログアウト
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/');
    }
}
