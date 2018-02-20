<?php
/**
 * プロフィールコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Constants\IconRoundType;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\User\Profile\ChangeIconImageRequest;
use Hgs3\Http\Requests\User\Profile\ChangeIconRoundRequest;
use Hgs3\Http\Requests\User\Profile\ConfigRequest;
use Hgs3\Http\Requests\User\Profile\EditRequest;
use Hgs3\Models\Orm;
use Hgs3\Models\Review;
use Hgs3\Models\Timeline;
use Hgs3\Models\User\Follow;
use Hgs3\Models\User\Profile;
use Hgs3\Models\User;
use Hgs3\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class ProfileController extends Controller
{
    /**
     * プロフィール
     *
     * @param string $showId
     * @param string $show
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($showId, $show = 'timeline')
    {
        $user = User::findByShowId($showId);
        if ($user == null) {
            return view('user.profile.notExist');
        }

        // データ数を取得
        $data = Profile::getDataNum($user->id);

        $data['user'] = $user;
        $data['isMyself'] = Auth::id() == $user->id;

        switch ($show) {
            case 'follow':{
                $follows = Follow::getFollow($user->id);
                $data['parts'] = [
                    'follows' => $follows,
                    'users'   => User::getHash(page_pluck($follows, 'follow_user_id')),
                    'mutualFollower' => Follow::getFollowerHash($user->id, page_pluck($follows, 'follow_user_id'))
                ];
            }
                break;
            case 'follower':{
                $followers = Follow::getFollower($user->id);
                $data['parts'] = [
                    'followers' => $followers,
                    'users'     => User::getHash(page_pluck($followers, 'user_id')),
                    'mutualFollow' => Follow::getFollowHash($user->id, page_pluck($followers, 'user_id'))
                ];
            }
                break;
            case 'favorite_soft':{

                $favoriteSofts = User\FavoriteSoft::get($user->id);

                $data['parts'] = [
                    'favoriteSofts' => $favoriteSofts,
                    'softs'         => Orm\GameSoft::getHash(page_pluck($favoriteSofts, 'soft_id'))
                ];
            }
                break;
            case 'review': {
                $r = new Review();
                $reviews = $r->getMypage($user->id);
                $data['parts'] = [
                    'reviews'      => $reviews,
                    'gamePackages' => Orm\GamePackage::getHash(page_pluck($reviews, 'package_id')),
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
                $favoriteSites = User\FavoriteSite::get($user->id);
                $sites = Orm\Site::getHash(page_pluck($favoriteSites, 'site_id'));

                $data['parts'] = [
                    'favoriteSites' => $favoriteSites,
                    'sites'         => $sites,
                    'users'         => User::getHash(array_pluck($sites, 'user_id'))
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
     * アイコン変更
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changeIcon()
    {
        return view('user.profile.changeIcon', [
            'user' => Auth::user()
        ]);
    }

    /**
     * アイコン丸み変更
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeIconRound()
    {
        return view('user.profile.changeIconRound', [
            'user' => Auth::user()
        ]);
    }

    /**
     * アイコン丸み変更処理
     *
     * @param ChangeIconRoundRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateIconRound(ChangeIconRoundRequest $request)
    {
        $user = Auth::user();
        $user->icon_round_type = $request->icon_round_type;
        $user->save();

        return redirect()->route('マイページ');
    }

    /**
     * アイコン画像変更
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeIconImage()
    {
        return view('user.profile.changeIconImage', [
            'user' => Auth::user()
        ]);
    }

    /**
     * アイコン画像変更
     *
     * @param ChangeIconImageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateIconImage(ChangeIconImageRequest $request)
    {
        $fileName = Auth::id() . '.' . $request->file('icon')->getClientOriginalExtension();

        $user = Auth::user();
        $user->deleteIconFile();

        $request->file('icon')->move(
            base_path() . '/public/img/user_icon/', $fileName
        );

        $user->icon_upload_flag = 1;
        $user->icon_file_name = $fileName;
        $user->icon_round_type = $request->icon_round_type;
        $user->save();

        return redirect()->route('マイページ');
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
        $user->icon_round_type = IconRoundType::NONE;
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
     * さらにタイムラインを取得
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function moreTimelineMyPage(User $user)
    {
        $time = floatval(Input::get('time', 0));
        return Response::json(Timeline\MyPage::getTimeline($user->id, $time, 20));
    }

    public function changeMail()
    {

    }

    public function updateMail()
    {

    }

    /**
     * 設定
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function config()
    {
        return view('user.profile.config', [
            'user'       => Auth::user(),
            'isComplete' => session('complete', 0) == 1
        ]);
    }

    /**
     * 設定更新
     *
     * @param ConfigRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateConfig(ConfigRequest $request)
    {
        $user = Auth::user();

        $user->footprint = $request->get('footprint');

        $user->save();

        return redirect()->back()->with('complete', 1);
    }
}
