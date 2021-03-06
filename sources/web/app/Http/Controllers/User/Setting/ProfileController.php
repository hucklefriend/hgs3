<?php
/**
 * プロフィール設定コントローラー
 */

namespace Hgs3\Http\Controllers\User\Setting;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\User\Setting\ProfileEditRequest;
use Hgs3\Http\Requests\User\Setting\ProfileOpenSettingRequest;
use Hgs3\Http\Requests\User\Setting\RateSettingRequest;
use Hgs3\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * @param ProfileOpenSettingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveOpenSetting(ProfileOpenSettingRequest $request)
    {
        DB::table('users')
            ->where('id', Auth::id())
            ->update(['open_profile_flag' => $request->get('flag', 1)]);

        return redirect()->route('ユーザー設定');
    }

    /**
     * プロフィール
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('user.setting.profile', [
            'user'       => Auth::user(),
            'attributes' => old('attribute', Auth::user()->getUserAttributes())
        ]);
    }

    /**
     * プロフィール保存
     *
     * @param ProfileEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function save(ProfileEditRequest $request)
    {
        DB::table('users')
            ->where('id', Auth::id())
            ->update([
                'name' => $request->get('name', ''),
                'profile' => cut_new_line($request->get('profile', ''))
            ]);

        $attribute = $request->get('attribute', []);
        User::saveAttribute(Auth::id(), $attribute);
        User\SearchIndex::save(Auth::user());

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
        DB::table('users')
            ->where('id', Auth::id())
            ->update(['adult' => $request->get('adult', 0)]);

        return redirect()->route('ユーザー設定');
    }

    /**
     * 足あと設定
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function footprint()
    {
        return view('user.setting.footprint', ['user' => Auth::user()]);
    }

    /**
     * 足あと設定保存
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveFootprint(Request $request)
    {
        $flag = $request->get('flag', 0);
        if ($flag != 1) {
            $flag = 0;
        }

        DB::table('users')
            ->where('id', Auth::id())
            ->update([
                'footprint' => $flag
            ]);

        return redirect()->route('ユーザー設定');
    }
}
