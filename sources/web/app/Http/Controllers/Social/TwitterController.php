<?php
/**
 * Twitterコントローラー
 */

namespace Hgs3\Http\Controllers\Social;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Log;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     */
    public function callback()
    {
        $user = Socialite::driver('twitter')->user();

        Log::debug(print_r($user, true));

        $mode = session('twitter');
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

        return view('social.twitter', ['user' => $user, 'mode' => $mode]);
    }

    /**
     * Twitterでアカウント作成
     *
     * @param \Laravel\Socialite\One\User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    private function createAccount(\Laravel\Socialite\One\User $user)
    {
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
        $sa = Orm\SocialAccount::findBySocialUserId(SocialSite::TWITTER, $socialUser->id);

        if ($sa != null) {
            $user = User::find($sa->user_id);
            if ($user != null) {
                // アカウント情報の更新
                $sa->nickname = $socialUser->nickname ?? null;
                $sa->name = $socialUser->name ?? null;
                $sa->save();

                Auth::login($user, true);
                return redirect()->route('マイページ');
            }
        }

        return view('social.twitter.notRegistered');
    }

    /**
     * 連携追加
     *
     * @param \Laravel\Socialite\One\User $socialUser
     * @return \Illuminate\Http\RedirectResponse
     */
    private function addAuth(\Laravel\Socialite\One\User $socialUser)
    {
        $sa = Orm\SocialAccount::findBySocialUserId(SocialSite::TWITTER, $socialUser->id);

        if ($sa != null) {
            // このTwitterアカウントは連携済み
            // TODO エラー表示
        } else {
            $sa = new Orm\SocialAccount();

            $sa->user_id = Auth::id();
            $sa->social_site_id = SocialSite::TWITTER;
            $sa->social_user_id = $socialUser->id;
            $sa->token = $socialUser->token;
            $sa->token_secret = $socialUser->tokenSecret;
            $sa->nickname = $socialUser->nickname ?? null;
            $sa->name = $socialUser->name ?? null;
            $sa->nickname = $socialUser->nickname ?? null;
            $sa->name = $socialUser->name ?? null;
            $sa->save();
        }

        return redirect()->route('SNS認証設定');
    }
}
