<?php
/**
 * フォローコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Log;
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function add(Request $request)
    {
        $followUserId = $request->get('follow_user_id');
        $followUser = User::findByShowId($followUserId);
        if ($followUser) {
            Follow::add(Auth::user(), $followUser, 0);
        }

        return redirect()->back();
    }

    /**
     * 削除
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Request $request)
    {
        $followUserId = $request->get('follow_user_id');
        $followUser = User::findByShowId($followUserId);
        Log::info($followUser->show_id);

        if ($followUser) {
            Follow::remove(Auth::user(), $followUser);
        }

        return redirect()->back();
    }
}
