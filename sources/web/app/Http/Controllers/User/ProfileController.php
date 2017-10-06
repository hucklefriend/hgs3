<?php
/**
 * プロフィールコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\User\Profile\UpdateRequest;
use Hgs3\Models\Community\GameCommunity;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\User\Follow;
use Hgs3\Models\User\Profile;
use Hgs3\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'home');
    }

    /**
     * プロフィール
     *
     * @param User $user
     * @param int $show
     * @return $this
     */
    public function index(User $user, $show = 'timeline')
    {
        $profile = new Profile();

        // データ数を取得
        $data = $profile->getDataNum($user->id);

        $data['user'] = $user;
        $data['isMyself'] = Auth::id() == $user->id;

        switch ($show) {
            case 'follow':
                break;
            case 'follower':
                break;
            case 'favorite_game':
                break;
            case 'site':
                break;
            case 'favorite_site':
                break;
            case 'diary':
                break;
            case 'community':
                break;
            case 'timeline':
            default:
                $show = 'timeline';
                break;
        }

        $data['show'] = $show;

        if (!$data['isMyself']) {
            $follow = new Follow();
            $data['isFollow'] = $follow->isFollow(Auth::id(), $user->id);
        }

        return view('user.profile.index', $data);
    }

    /**
     * プロフィール
     *
     * @return $this
     */
    public function myself()
    {
        return $this->index(Auth::user());
    }

    /**
     * プロフィール編集
     *
     * @return $this
     */
    public function edit()
    {
        return view('user.profile.edit')->with([
            'isUpdated' => false,
            'user'      => Auth::user()
        ]);
    }

    /**
     * プロフィール編集
     *
     * @param UpdateRequest $request
     * @return $this
     */
    public function update(UpdateRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->get('name') ?? '';
        $user->adult = intval($request->get('adult') ?? 0);
        if ($user->adult != 1) {
            $user->adult = 0;
        }

        $user->save();

        return view('user.profile.edit')->with([
            'isUpdated' => true,
            'user'      => $user
        ]);
    }

    /**
     * フォロー一覧
     */
    public function follow(User $user)
    {
        $isMyself = $user->id == Auth::id();

        $follow = new Follow;
        $follows = $follow->getFollow($user->id);

        return view('user.profile.follow')->with([
            'user'     => $user,
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
     * コミュニティ
     *
     * @param User $user
     * @return $this
     */
    public function community(User $user)
    {
        $isMyself = $user->id == Auth::id();

        $gc = new GameCommunity();
        $communities = $gc->getJoinCommunity($user->id);

        return view('user.profile.community')->with([
            'user'        => $user,
            'isMyself'    => $isMyself,
            'communities' => $communities,
            'games'       => Game::getNameHash(array_pluck($communities->items(), 'game_id'))
        ]);
    }
}
