<?php
/**
 * Friendコントローラ
 */

namespace Hgs3\Http\Controllers\Friend;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Friend;

class FriendController extends Controller
{
    /**
     * フレンドトップページ
     */
    public function index()
    {

        return view('friend.index', [
            'users' => Friend::getList()
        ]);
    }
}
