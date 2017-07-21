<?php
/**
 * お気に入りコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    public function index()
    {
        return view('user.game.favorite');
    }

    public function add(Request $request)
    {

    }

    public function remove()
    {
        return view('mypage.profile');
    }
}
