<?php
/**
 * Friendコントローラ
 */

namespace Hgs3\Http\Controllers\Review;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Review;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class FriendController extends Controller
{
    /**
     * フレンドトップページ
     */
    public function index()
    {
        return view('friend.index');
    }

}
