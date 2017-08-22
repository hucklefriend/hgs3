<?php

namespace Hgs3\Http\Controllers\Account;

use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Hgs3\Http\Requests\AuthenticateRequest;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(AuthenticateRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
            // 認証に成功した
            return redirect()->intended('/');
        } else {
            return back()->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/');
    }
}
