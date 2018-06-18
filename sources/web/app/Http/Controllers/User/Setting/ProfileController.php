<?php
/**
 * プロフィール設定コントローラー
 */

namespace Hgs3\Http\Controllers\User\Setting;

use Hgs3\Constants\IconRoundType;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\User\Profile\ChangeIconImageRequest;
use Hgs3\Http\Requests\User\Profile\ChangeIconRoundRequest;
use Hgs3\Http\Requests\User\Profile\ConfigRequest;
use Hgs3\Http\Requests\User\Profile\EditRequest;
use Hgs3\Http\Requests\User\Profile\ProfileEditRequest;
use Hgs3\Http\Requests\User\Profile\RateSettingRequest;
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
     * 公開範囲設定
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function openSetting()
    {
        return view('user.setting.open', ['user' => Auth::user()]);
    }

    /**
     * 公開範囲を保存
     *
     * @param ProfileEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveOpenSetting(ProfileEditRequest $request)
    {
        $user = Auth::user();
        $user->open_profile_flag = $request->get('flag', 1);

        $user->save();

        return redirect()->route('ユーザー設定');
    }

    /**
     * プロフィール
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('user.setting.profile', ['user' => Auth::user()]);
    }

    /**
     * プロフィール保存
     *
     * @param ProfileEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(ProfileEditRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->get('name', '');
        $user->profile = cut_new_line($request->get('profile', ''));

        $user->save();

        return redirect()->route('ユーザー設定');
    }

    /**
     * R-18表示設定
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rate()
    {
        return view('user.setting.rate', ['user' => Auth::user()]);
    }

    /**
     * R-18表示設定保存
     *
     * @param RateSettingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveRate(RateSettingRequest $request)
    {
        $user = Auth::user();
        $user->adult = $request->get('is_adult', 0);

        $user->save();

        return redirect()->route('ユーザー設定');
    }
}
