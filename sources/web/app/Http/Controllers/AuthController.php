<?php

namespace Hgs3\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'home');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function logout()
    {

    }
}
