<?php
/**
 * プロフィールコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\User\Profile\UpdateRequest;
use Hgs3\Models\Community\GameCommunity;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\Site;
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
            case 'follow':{
                $follow = new Follow;
                $follows = $follow->getFollow($user->id);
                $data['parts'] = [
                    'follows' => $follows,
                    'users'   => User::getHash(array_pluck($follows->items(), 'follow_user_id')),
                ];
            }
                break;
            case 'follower':{
                $follow = new Follow;
                $follows = $follow->getFollower($user->id);
                $data['parts'] = [
                    'followers' => $follows,
                    'users'     => User::getHash(array_pluck($follows->items(), 'user_id')),
                ];
            }
                break;
            case 'favorite_game':{
                $fg = new \Hgs3\Models\User\FavoriteGame();
                $data['parts'] = [
                    'favGames' => $fg->get($user->id),
                    'games'    => Game::getNameHash()
                ];
            }
                break;
            case 'site': {
                $site = new \Hgs3\Models\Site();
                $data['parts'] = [
                    'sites' => $site->get($user->id)
                ];
            }
                break;
            case 'favorite_site': {
                $fs = new \Hgs3\Models\User\FavoriteSite();
                $favSites = $fs->get($user->id);

                $sites = Site::getHash(array_pluck($favSites->items(), 'site_id'));

                $data['parts'] = [
                    'favSites' => $favSites,
                    'sites'    => $sites,
                    'users'    => User::getNameHash(array_pluck($sites, 'user_id'))
                ];
            }
                break;
            case 'diary': {
                $data['parts'] = [];
            }
                break;
            case 'community': {
                $gc = new GameCommunity();
                $communities = $gc->getJoinCommunity($user->id);
                $data['parts'] = [
                    'communities' => $communities,
                    'games'       => Game::getNameHash(array_pluck($communities->items(), 'game_id'))
                ];
            }
                break;
            case 'timeline':
            default: {
                $show = 'timeline';
                $data['parts'] = [];
        }
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
            'users'    => User::getHash(array_pluck($follows->items(), 'follow_user_id'))
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
     * お気に入りゲーム一覧
     *
     * @param User $user
     * @return $this
     */
    public function favoriteGame(User $user)
    {
        $isMyself = $user->id == Auth::id();

        $fg = new \Hgs3\Models\User\FavoriteGame();
        $favGames = $fg->get($user->id);

        return view('user.profile.favorite_game')->with([
            'user'     => $user,
            'isMyself' => $isMyself,
            'favGames' => $favGames,
            'games'    => Game::getNameHash(array_pluck($favGames->items(), 'game_id'))
        ]);
    }

    /**
     * サイト一覧
     *
     * @param User $user
     * @return $this
     */
    public function site(User $user)
    {
        $isMyself = $user->id == Auth::id();

        $site = new \Hgs3\Models\Site();

        return view('user.profile.site')->with([
            'user'     => $user,
            'isMyself' => $isMyself,
            'sites'    => $site->get($user->id)
        ]);
    }

    /**
     * お気に入りサイト一覧
     *
     * @param User $user
     * @return $this
     */
    public function favoriteSite(User $user)
    {
        $isMyself = $user->id == Auth::id();

        $fs = new \Hgs3\Models\User\FavoriteSite();
        $favSites = $fs->get($user->id);
        $sites = Site::getHash(array_pluck($favSites->items(), 'site_id'));

        return view('user.profile.favorite_site')->with([
            'user'     => $user,
            'isMyself' => $isMyself,
            'favSites' => $favSites,
            'sites'    => $sites,
            'users'    => User::getNameHash(array_pluck($sites, 'user_id'))
        ]);
    }

    /**
     * 日記
     *
     * @param User $user
     * @return $this
     */
    public function diary(User $user)
    {
        $isMyself = $user->id == Auth::id();

        return view('user.profile.diary')->with([
            'user'     => $user,
            'isMyself' => $isMyself,
            'diaries'  => []
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
