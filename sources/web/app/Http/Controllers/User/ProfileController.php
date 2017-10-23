<?php
/**
 * プロフィールコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\User\Profile\ChangeIconRequest;
use Hgs3\Http\Requests\User\Profile\EditRequest;
use Hgs3\Models\Community\GameCommunity;
use Hgs3\Models\Orm;
use Hgs3\Models\Review;
use Hgs3\Models\Timeline;
use Hgs3\Models\User\Follow;
use Hgs3\Models\User\Profile;
use Hgs3\Models\User;
use Hgs3\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

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
     * @param string $show
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
                    'games'    => Orm\GameSoft::getNameHash()
                ];
            }
                break;
            case 'review': {
                $r = new Review();
                $reviews = $r->getMypage($user->id);
                $data['parts'] = [
                    'reviews'      => $reviews,
                    'gamePackages' => Orm\GamePackage::getHash(array_pluck($reviews->items(), 'package_id')),
                ];
            }
                break;
            case 'site': {
                $site = new Site();
                $data['parts'] = [
                    'sites' => $site->get($user->id)
                ];
            }
                break;
            case 'favorite_site': {
                $fs = new \Hgs3\Models\User\FavoriteSite();
                $favSites = $fs->get($user->id);

                $sites = Orm\Site::getHash(array_pluck($favSites->items(), 'site_id'));

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
                    'games'       => Orm\GameSoft::getNameHash(array_pluck($communities->items(), 'game_id'))
                ];
            }
                break;
            case 'timeline':
            default: {
                $show = 'timeline';
                $myPage = new Timeline\MyPage();

                $data['parts'] = $myPage->getTimeline($user->id, time(), 20);
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('user.profile.edit', [
            'isUpdated' => false,
            'user'      => Auth::user()
        ]);
    }

    /**
     * プロフィール編集
     *
     * @param EditRequest $request
     * @return $this
     */
    public function update(EditRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->get('name', '');
        $user->profile = cut_new_line($request->get('profile', ''));
        $user->adult = intval($request->get('adult', 0));
        if ($user->adult != 1) {
            $user->adult = 0;
        }

        $user->save();

        return redirect('mypage');
    }

    /**
     * アイコン選択
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function selectIcon()
    {
        return view('user.profile.selectIcon', [
            'user'      => Auth::user(),
            'csrfToken' => csrf_token()
        ]);
    }

    /**
     * アイコン変更
     *
     * @param ChangeIconRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeIcon(ChangeIconRequest $request)
    {
        $fileName = Auth::id() . '.' . $request->file('icon')->getClientOriginalExtension();

        $user = Auth::user();
        $user->deleteIconFile();

        $request->file('icon')->move(
            base_path() . '/public/img/user_icon/', $fileName
        );

        $user->icon_upload_flag = 1;
        $user->icon_file_name = $fileName;
        $user->save();

        return redirect('mypage');
    }

    /**
     * アイコン削除
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteIcon()
    {
        $user = Auth::user();

        $user->icon_upload_flag = 0;
        $user->icon_file_name = null;
        $user->save();

        $user->deleteIconFile();

        return redirect('mypage');
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
            'games'    => GameSoft::getNameHash(array_pluck($favGames->items(), 'game_id'))
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
        $sites = Orm\Site::getHash(array_pluck($favSites->items(), 'site_id'));

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
            'games'       => Orm\GameSoft::getNameHash(array_pluck($communities->items(), 'game_id'))
        ]);
    }

    /**
     * さらにタイムラインを取得
     *
     * @param User $user
     * @param $time
     * @return \Illuminate\Http\JsonResponse
     */
    public function moreTimelineMyPage(User $user, $time)
    {
        $time = floatval($time);

        $myPage = new Timeline\MyPage();

        return Response::json($myPage->getTimeline($user->id, $time, 20));
    }
}
