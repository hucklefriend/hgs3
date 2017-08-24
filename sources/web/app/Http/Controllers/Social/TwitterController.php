<?php
/**
 * Twitterコントローラー
 */

namespace Hgs3\Http\Controllers\Social;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Orm\SocialAccount;
use Laravel\Socialite\Facades\Socialite;
use Hgs3\Constants\Social\Twitter\Mode;

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
        session('twitter', $mode);

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

        return view('social.twitter', ['user' => $user]);
    }

    private function createAccount(\Laravel\Socialite\One\User $user)
    {
        // 登録済みアカウントかチェック


        // データ登録
        $account = SocialAccount::firstOrCreate([
            'provider_user_id' => $providerUser->getId(),
            'provider'         => $provider,
        ]);


        return redirect('mypage');
    }

    private function login(\Laravel\Socialite\One\User $user)
    {
        return redirect('mypage');
    }

    public function createOrGetUser($providerUser, $provider)
    {


        $account = SocialAccount::firstOrCreate([
            'provider_user_id' => $providerUser->getId(),
            'provider'         => $provider,
        ]);

        if (empty($account->user))
        {
            $user = User::create([
                'name'   => $providerUser->getName(),
            ]);
            $account->user()->associate($user);
        }

        $account->provider_access_token = $providerUser->token;
        $account->save();

        return $account->user;
    }
}
