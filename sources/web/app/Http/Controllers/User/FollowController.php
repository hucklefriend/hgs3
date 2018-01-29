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
     * フォロー一覧
     *
     * @param string $showId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($showId)
    {
        $user = User::findByShowId($showId);
        if ($user == null) {
            return view('user.profile.notExist');
        }

        $isMyself = $user->id == Auth::id();
        $follows = Follow::getFollow($user->id);

        return view('user.profile.follow', [
            'user'     => $user,
            'isMyself' => $isMyself,
            'follows'  => $follows,
            'users'    => User::getHash(array_pluck($follows->items(), 'follow_user_id'))
        ]);
    }

    /**
     * フォロワー一覧
     *
     * @param string $showId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function follower($showId)
    {
        $user = User::findByShowId($showId);
        if ($user == null) {
            return view('user.profile.notExist');
        }

        $isMyself = $user->id == Auth::id();
        $follows = Follow::getFollower($user->id);

        return view('user.profile.follower', [
            'user'       => $user,
            'isMyself'   => $isMyself,
            'followers'  => $follows,
            'users'      => User::getHash(array_pluck($follows->items(), 'user_id'))
        ]);
    }

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
