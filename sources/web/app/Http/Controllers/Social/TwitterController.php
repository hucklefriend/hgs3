<?php
/**
 * Twitterコントローラー
 */

namespace Hgs3\Http\Controllers\Social;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Account\SignUp;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Hgs3\Constants\Social\Mode;
use Hgs3\Constants\SocialSite;

class TwitterController extends Controller
{
    /**
     * コンストラクタ
     *
     * @return void
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'community');
    }

    /**
     * Twitter認証画面へ遷移
     *
     * @param $mode
     * @return mixed
     */
    public function redirect($mode)
    {
        $mode = intval($mode);
        session(['twitter' => $mode]);

        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Twitterからのコールバック
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function callback()
    {
        $user = Socialite::driver('twitter')->user();

        $mode = session('twitter');
        switch ($mode) {
            case Mode::CREATE_ACCOUNT:
                return $this->createAccount($user);
                break;
            case Mode::LOGIN:
                return $this->login($user);
                break;
            case Mode::ADD_AUTH:
                break;
            default:
                break;
        }

        return view('social.twitter', ['user' => $user, 'mode' => $mode]);
    }

    /**
     * Twitterでアカウント作成
     *
     * @param \Laravel\Socialite\One\User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function createAccount(\Laravel\Socialite\One\User $user)
    {
        $signUp = new SignUp();

        $sa = new Orm\SocialAccount;
        if ($sa->isRegistered(SocialSite::TWITTER, $user->id)) {
            return view('social.twitter.alreadyRegistered');
        } else {
            SignUp::registerBySocialite($user, SocialSite::TWITTER);
            return view('social.twitter.createAccount');
        }
    }

    /**
     * ログイン
     *
     * @param \Laravel\Socialite\One\User $socialUser
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    private function login(\Laravel\Socialite\One\User $socialUser)
    {
        $sa = new SocialAccount;
        $userId = $sa->getUserId(SocialSite::TWITTER, $socialUser->id);

        if ($userId != null) {
            $user = User::find($userId);
            if ($user != null) {
                Auth::login($user, true);
                return redirect('mypage');
            }
        }

        return view('social.twitter.notRegistered');
    }
}
