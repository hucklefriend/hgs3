<?php
/**
 * マイページコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Review\Review;
use Hgs3\Models\User\Follow;
use Hgs3\User;
use Illuminate\Support\Facades\Auth;
use Hgs3\Models\Timeline;

class MyPageController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'home');
    }

    /**
     * マイページ
     *
     * @return $this
     */
    public function index()
    {
        return redirect('user/profile/'.Auth::id());
    }

    /**
     * @return $this
     */
    public function follow()
    {
        $isMyself = true;

        $follow = new Follow;
        $follows = $follow->getFollow(Auth::id());

        return view('user.profile.follow')->with([
            'user'     => Auth::user(),
            'isMyself' => $isMyself,
            'follows'  => $follows,
            'users'    => User::getNameHash(array_pluck($follows->items(), 'follow_user_id'))
        ]);
    }

    /**
     * フォロワー一覧
     *
     * @param User $user
     * @return $this
     */
    public function follower(User $user)
    {
        $isMyself = $user->id == Auth::id();

        $follow = new Follow;
        $follows = $follow->getFollower($user->id);

        return view('user.profile.follower')->with([
            'user'       => $user,
            'isMyself'   => $isMyself,
            'followers'  => $follows,
            'users'      => User::getNameHash(array_pluck($follows->items(), 'user_id'))
        ]);
    }

    /**
     * 自分が投稿したレビュー
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function review()
    {
        $review = new Review();

        $reviews = $review->getUser(Auth::id());

        return view('user.game.review', [
            'reviews'  => $reviews,
            'user'     => Auth::user()
        ]);
    }
}
