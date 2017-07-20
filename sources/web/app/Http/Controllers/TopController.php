<?php
namespace Hgs3\Http\Controllers;

use Hgs3\Constants\UserRole;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TopController extends Controller
{
    public function index()
    {
        return view('top', [
            'isLogin' => Auth::check(),
            'isAdmin' => UserRole::isAdmin()
        ]);
    }
}
