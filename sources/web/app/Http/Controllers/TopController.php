<?php
namespace Hgs3\Http\Controllers;

use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TopController extends Controller
{
    public function index()
    {
/*
        \Hgs3\User::create([
            'name'     => 'huckle',
            'email'    => 'yuuki@horrorgame.net',
            'password' => bcrypt('huckle'),
        ]);
*/
        return view('top', [
            'isLogin' => Auth::check()
        ]);
    }
}
