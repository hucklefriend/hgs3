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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
            case 'favorite_soft':{
                $data['parts'] = [
                    'favoriteSofts' => User\FavoriteSoft::get($user->id),
                    'softs'         => Orm\GameSoft::getNameHash()
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
                $data['parts'] = [
                    'sites'       => Site::getUserSites($user->id, $data['isMyself']),
                    'hasHgs2Site' => Site\TakeOver::hasHgs2Site($user)
                ];
            }
                break;
            case 'favorite_site': {
                $favSites = User\FavoriteSite::get($user->id);
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
                $communities = GameCommunity::getJoinCommunity($user->id);
                $data['parts'] = [
                    'communities' => $communities,
                    'softs'       => Orm\GameSoft::getNameHash(array_pluck($communities->items(), 'soft_id'))
                ];
            }
                break;
            case 'timeline':
            default: {
                $show = 'timeline';
                $data['parts'] = Timeline\MyPage::getTimeline($user->id, time(), 20);
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
            'user' => Auth::user()
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
     * タイムライン
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function timeline()
    {
        $data = Timeline\MyPage::getTimeline(Auth::id(), time(), 20);
        $data['user'] = Auth::user();
        $data['isMyself'] = true;

        return view('user.profile.timeline', $data);
    }

    /**
     * フォロー一覧
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function follow(User $user)
    {
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
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function follower(User $user)
    {
        $isMyself = $user->id == Auth::id();
        $follows = Follow::getFollower($user->id);

        return view('user.profile.follower', [
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function favoriteSoft(User $user)
    {
        $isMyself = $user->id == Auth::id();

        $favoriteSofts = User\FavoriteSoft::get($user->id);

        return view('user.profile.favorite_soft', [
            'user'          => $user,
            'isMyself'      => $isMyself,
            'favoriteSofts' => $favoriteSofts,
            'softs'         => Orm\GameSoft::getNameHash(array_pluck($favoriteSofts->items(), 'soft_id'))
        ]);
    }

    /**
     * サイト一覧
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function site(User $user)
    {
        $isMyself = $user->id == Auth::id();

        return view('user.profile.site', [
            'user'     => $user,
            'isMyself' => $isMyself,
            'sites'    => Site::get($user->id)
        ]);
    }

    /**
     * お気に入りサイト一覧
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function favoriteSite(User $user)
    {
        $isMyself = $user->id == Auth::id();

        $favSites = User\FavoriteSite::get($user->id);
        $sites = Orm\Site::getHash(array_pluck($favSites->items(), 'site_id'));

        return view('user.profile.favorite_site', [
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function diary(User $user)
    {
        $isMyself = $user->id == Auth::id();

        return view('user.profile.diary', [
            'user'     => $user,
            'isMyself' => $isMyself,
            'diaries'  => []
        ]);
    }

    /**
     * コミュニティ
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function community(User $user)
    {
        $isMyself = $user->id == Auth::id();
        $communities = GameCommunity::getJoinCommunity($user->id);

        return view('user.profile.community', [
            'user'        => $user,
            'isMyself'    => $isMyself,
            'communities' => $communities,
            'softs'       => Orm\GameSoft::getNameHash(array_pluck($communities->items(), 'soft_id'))
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
        return Response::json(Timeline\MyPage::getTimeline($user->id, $time, 20));
    }

    public function changeMail()
    {

    }

    public function updateMail()
    {

    }
}
