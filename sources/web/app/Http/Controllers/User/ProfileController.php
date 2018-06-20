<?php
/**
 * プロフィールコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Constants\IconRoundType;
use Hgs3\Constants\PageId;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\User\Profile\ChangeIconImageRequest;
use Hgs3\Http\Requests\User\Profile\ChangeIconRoundRequest;
use Hgs3\Http\Requests\User\Profile\ConfigRequest;
use Hgs3\Http\Requests\User\Profile\EditRequest;
use Hgs3\Models\Account\SocialSite;
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
    public function index($showId, $show = 'profile')
    {
        $user = User::findByShowId($showId);
        if ($user == null) {
            return view('user.profile.notExist');
        }

        // データ数を取得
        $data = Profile::getDataNum($user->id);

        $data['user'] = $user;
        $data['isMyself'] = Auth::id() == $user->id;

        $open = true;
        $openMenu = true;
        if (!$data['isMyself']) {
            if ($user->open_profile_flag == 0) {
                $open = false;
                $openMenu = false;
            } else if ($user->open_profile_flag == 1) {
                if (Auth::check()) {
                    $open = true;
                } else {
                    $open = ($show == 'site' || $show == 'review');
                }
                $openMenu = Auth::check();
            } else {
                $open = true;
                $openMenu = true;
            }
        }

        if ($open == false) {
            $show = 'review';
        }

        $data['open'] = $openMenu;

        switch ($show) {
            case 'follow':{
                $title = 'フォロー';
                $follows = Follow::getFollow($user->id);
                $data['parts'] = [
                    'follows' => $follows,
                    'users'   => User::getHash(page_pluck($follows, 'follow_user_id')),
                    'mutualFollower' => Follow::getFollowerHash($user->id, page_pluck($follows, 'follow_user_id'))
                ];
                $data['pageId'] = $data['isMyself'] ? PageId::USER_FOLLOW : PageId::FRIEND_FOLLOW;
            }
                break;
            case 'follower':{
                $title = 'フォロワー';
                $followers = Follow::getFollower($user->id);
                $data['parts'] = [
                    'followers' => $followers,
                    'users'     => User::getHash(page_pluck($followers, 'user_id')),
                    'mutualFollow' => Follow::getFollowHash($user->id, page_pluck($followers, 'user_id'))
                ];
                $data['pageId'] = $data['isMyself'] ? PageId::USER_FOLLOWER : PageId::FRIEND_FOLLOWER;
            }
                break;
            case 'favorite_soft':{
                $title = 'お気に入りゲーム';
                $favoriteSofts = User\FavoriteSoft::get($user->id);

                $data['parts'] = [
                    'favoriteSofts' => $favoriteSofts,
                    'softs'         => Orm\GameSoft::getHash(page_pluck($favoriteSofts, 'soft_id'))
                ];
                $data['pageId'] = $data['isMyself'] ? PageId::USER_FAVORITE_GAME : PageId::FRIEND_FAVORITE_GAME;
            }
                break;
            case 'review': {
                $title = 'レビュー';
                $data['parts'] = [
                    'reviews' => Review::getProfileList($user),
                ];
                $data['pageId'] = $data['isMyself'] ? PageId::USER_REVIEW : PageId::FRIEND_REVIEW;
            }
                break;
            case 'review_draft': {
                $title = 'レビュー下書き';
                $data['parts'] = [
                    'drafts' => Review::getProfileDraftList($user),
                ];
                $data['pageId'] = PageId::USER_REVIEW_DRAFT;
            }
                break;
            case 'site': {
                $title = 'サイト';
                $data['parts'] = [
                    'sites' => Site::getUserSites($user->id, $data['isMyself'])
                ];
                $data['pageId'] = $data['isMyself'] ? PageId::USER_SITE : PageId::FRIEND_SITE;
            }
                break;
            case 'favorite_site': {
                $title = 'お気に入りサイト';
                $favoriteSites = User\FavoriteSite::get($user->id);
                $sites = Orm\Site::getHash(page_pluck($favoriteSites, 'site_id'));

                $data['parts'] = [
                    'favoriteSites' => $favoriteSites,
                    'sites'         => $sites,
                    'users'         => User::getHash(array_pluck($sites, 'user_id'))
                ];
                $data['pageId'] = $data['isMyself'] ? PageId::USER_FAVORITE_SITE : PageId::FRIEND_FAVORITE_SITE;
            }
                break;
            case 'good_site': {
                $title = 'いいねしたサイト';
                $goodSites = Site\Good::getList($user);
                $sites = Orm\Site::getHash(page_pluck($goodSites, 'site_id'));

                $data['parts'] = [
                    'goodSites' => $goodSites,
                    'sites'     => $sites,
                    'users'     => User::getHash(array_pluck($sites, 'user_id'))
                ];
                $data['pageId'] = PageId::USER_GOOD_SITE;
            }
                break;
            case 'timeline': {
                $title = 'タイムライン';
                $data['parts'] = Timeline\MyPage::getTimeline($data['isMyself'], Auth::id(), time(), 20);
                $data['pageId'] = $data['isMyself'] ? PageId::USER_TIMELINE : PageId::FRIEND_TIMELINE;
            }
                break;
            case 'profile':
            default: {
                $show = 'profile';
                $title = 'プロフィール';
                $data['parts'] = [
                    'snsAccounts' => SocialSite::getAccounts($user, true)
                ];
                $data['pageId'] = $data['isMyself'] ? PageId::USER_PROFILE : PageId::FRIEND_PROFILE;
            }
                break;
        }

        $data['show'] = $show;
        $data['title'] = $title;

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
     * プロフィール
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($showId)
    {
        $user = User::findByShowId($showId);
        if ($user == null) {
            return view('user.profile.notExist');
        }

        return view('user.profile.show', [
            'user'        => $user,
            'snsAccounts' => SocialSite::getAccounts($user, true)
        ]);
    }

    /**
     * さらにタイムラインを取得
     *
     * @param string $showId
     * @return \Illuminate\Http\JsonResponse
     */
    public function moreTimelineMyPage($showId)
    {
        $user = User::findByShowId($showId);

        $isMyself = $user->id == Auth::id();

        $time = floatval(Input::get('time', 0));
        return Response::json(Timeline\MyPage::getTimeline($isMyself, $user->id, $time, 20));
    }
}
