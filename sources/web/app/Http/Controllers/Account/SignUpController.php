<?php
/**
 * サインアップコントローラー
 */

namespace Hgs3\Http\Controllers\Account;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\SendPRMailRequestRequest;
use Hgs3\Models\Account\SignUp;

class SignUpController extends Controller
{
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
     * @param SendPRMailRequestRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendPRMail(SendPRMailRequestRequest $request)
    {
        $email = $request->get('email');

        $signUp = new SignUp();
        $token = $signUp->sendProvisionalRegistrationMail($email);

        return view('account.sendPRMail', [
            'token' => $token,
            'email' => $email
        ]);
    }

    public function register($email, $token)
    {

    }
}
