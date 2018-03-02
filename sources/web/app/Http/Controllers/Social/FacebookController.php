<?php
/**
 * Facebookコントローラー
 */

namespace Hgs3\Http\Controllers\Social;

use Hgs3\Constants\Social\Mode;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Log;
use Hgs3\Models\Account\SignUp;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Hgs3\Constants\SocialSite;

class FacebookController extends Controller
{
    /**
     * Facebook認証画面へ遷移
     *
     * @param $mode
     * @return mixed
     */
    public function redirect($mode)
    {
        $mode = intval($mode);
        session(['facebook' => $mode]);

        $facebook = Socialite::driver('facebook');

        return $facebook->redirect();
    }

    /**
     * Facebook
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     */
    public function callback()
    {
        $user = Socialite::driver('facebook')->user();

        $mode = session('facebook');
        switch ($mode) {
            case Mode::CREATE_ACCOUNT:
                return $this->createAccount($user);
                break;
            case Mode::LOGIN:
                return $this->login($user);
                break;
            case Mode::ADD_AUTH:
                return $this->addAuth($user);
                break;
            default:
                break;
        }

        return view('social.facebook', ['user' => $user, 'mode' => $mode]);
    }

    /**
     * ユーザー登録
     *
     * @param \Laravel\Socialite\Two\User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    private function createAccount(\Laravel\Socialite\Two\User $user)
    {
        $signUp = new SignUp();

        $sa = new Orm\SocialAccount;
        if ($sa->isRegistered(SocialSite::FACEBOOK, $user->id)) {
            return view('social.facebook.alreadyRegistered');
        } else {
            $signUp->registerBySocialite2($user, SocialSite::FACEBOOK);
            return view('social.facebook.createAccount', ['user' => $user]);
        }
    }

    /**
     * ログイン
     *
     * @param \Laravel\Socialite\Two\User $socialUser
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    private function login(\Laravel\Socialite\Two\User $socialUser)
    {
        $sa = new Orm\SocialAccount;
        $userId = $sa->getUserId(SocialSite::FACEBOOK, $socialUser->id);

        if ($userId != null) {
            $user = User::find($userId);
            if ($user != null) {
                Auth::login($user, true);
                return redirect('mypage');
            }
        }

        return view('social.facebook.notRegistered');
    }

    /**
     * 連携追加
     *
     * @param \Laravel\Socialite\Two\User $socialUser
     * @return \Illuminate\Http\RedirectResponse
     */
    private function addAuth(\Laravel\Socialite\Two\User $socialUser)
    {
        $sa = Orm\SocialAccount::findBySocialUserId(SocialSite::FACEBOOK, $socialUser->id);

        if ($sa != null) {
            // このTwitterアカウントは連携済み
            return view('user.setting.snsAlwaysRegistered', ['sns' => 'facebook']);
        } else {
            $sa = new Orm\SocialAccount();

            $sa->user_id = Auth::id();
            $sa->social_site_id = SocialSite::FACEBOOK;
            $sa->social_user_id = $socialUser->id;
            $sa->token = $socialUser->token;
            $sa->token_secret = '';
            $sa->url = $socialUser->profileUrl ?? null;
            $sa->name = $socialUser->getName();
            $sa->save();
        }

        return redirect()->route('SNS認証設定');
    }
}
