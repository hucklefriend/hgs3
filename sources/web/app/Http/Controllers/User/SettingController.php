<?php
/**
 * ユーザー設定コントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\User\Setting\SnsOpenRequest;
use Hgs3\Http\Requests\User\Profile\EditRequest;
use Hgs3\Models\Account\SocialSite;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\Auth;

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

    /**
     * SNS連携設定
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * 公開フラグ更新
     *
     * @param SnsOpenRequest $request
     * @param Orm\SocialAccount $sa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSnsOpen(SnsOpenRequest $request, Orm\SocialAccount $sa)
    {
        if ($sa->user_id != Auth::id()) {
            return redirect()->back();
        }

        $sa->open_flag = $request->get('open_flag');
        $sa->save();

        return redirect()->back();
    }

    /**
     * 連携解除
     *
     * @param Orm\SocialAccount $sa
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteSns(Orm\SocialAccount $sa)
    {
        $user = Auth::user();

        if ($sa->user_id != $user->id) {
            return redirect()->back();
        }

        $accounts = SocialSite::getAccounts($user);
        if ($accounts->count() <= 1 && !$user->isRegisteredMailAuth()) {
            // 削除できない
            return view('user.setting.snsCannotDelete');
        }

        $sa->delete();

        return redirect()->back();
    }
}
