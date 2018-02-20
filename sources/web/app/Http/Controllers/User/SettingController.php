<?php
/**
 * ユーザー設定コントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Constants\IconRoundType;
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

class SettingController extends Controller
{
    /**
     * ユーザー設定メニュー
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        return view('user.setting.index', [
            'user'        => $user,
            'snsAccounts' => SocialSite::getAccounts($user)
        ]);
    }

    /**
     * プロフィール編集
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile()
    {
        return view('user.setting.profile', [
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
    public function updateProfile(EditRequest $request)
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

    public function sns()
    {
        $user = Auth::user();
        $snsAccountHash = SocialSite::getAccounts($user)
            ->keyBy('social_site_id');

        return view('user.setting.sns', [
            'user'        => $user,
            'snsAccountHash' => $snsAccountHash
        ]);
    }

    public function deleteSns($socialSiteId)
    {

    }
}
