<?php
/**
 * フォローコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Models\User\Follow;
use Hgs3\Models\User;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * フォローする
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
        $followUserId = $request->get('follow_user_id');
        $followUser = User::find($followUserId);
        if ($followUser) {
            $follow = new Follow();
            $follow->add(Auth::user(), $followUser, 0);
        }

        return redirect()->back();
    }

    /**
     * 削除
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        $follow = new Follow();
        $follow->remove(Auth::id(), $request->get('follow_user_id'));

        return redirect()->back();
    }
}
