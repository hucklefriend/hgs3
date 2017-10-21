<?php
/**
 * サインアップコントローラー
 */

namespace Hgs3\Http\Controllers\Account;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Account\RegisterRequest;
use Hgs3\Http\Requests\Account\SendPRMailRequest;
use Hgs3\Models\Account\SignUp;
use Hgs3\Models\Orm;

class SignUpController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'home');
    }

    /**
     * サインアップ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('account.signup');
    }

    /**
     * メール送信
     *
     * @param SendPRMailRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendPRMail(SendPRMailRequest $request)
    {
        $email = $request->get('email');

        $signUp = new SignUp();
        $token = $signUp->sendProvisionalRegistrationMail($email);

        return view('account.sendPRMail', [
            'token' => $token
        ]);
    }

    /**
     * 登録画面
     *
     * @param string $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register($token)
    {
        $signUp = new SignUp();

        if (!$signUp->validateToken($token)) {
            $signUp->deleteToken($token);
            return view('account.tokenError');
        } else {
            $orm = Orm\UserProvisionalRegistration::where('token', $token)
                ->first();

            return view('account.register', [
                'pr' => $orm
            ]);
        }
    }

    /**
     * 本登録
     *
     * @param RegisterRequest $request
     */
    public function registration(RegisterRequest $request)
    {
        $signUp = new SignUp();

        $token = $request->get('token');

        if (!$signUp->validateToken($token)) {
            $signUp->deleteToken($token);
            return view('account.tokenError');
        } else {
            $signUp->register($token, $request->get('name'), $request->get('password'));

            return view('account.complete');
        }
    }
}
