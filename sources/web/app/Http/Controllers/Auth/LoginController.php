<?php

namespace Hgs3\Http\Controllers\Auth;

use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();

        return array();
    }
}
