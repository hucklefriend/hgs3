<?php
/**
 * サインアップコントローラー
 */

namespace Hgs3\Http\Controllers\Account;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Account\RegisterRequest;
use Hgs3\Http\Requests\Account\SendPRMailRequest;
use Hgs3\Mail\ProvisionalRegistration;
use Hgs3\Models\Account\SignUp;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
     * @param SendPRMailRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function sendPRMail(SendPRMailRequest $request)
    {
        $email = $request->get('email');

        $emailHash = md5($email);

        // 登録無視対象か？
        $ignore = Orm\IgnoreProvisionalRegistrations::find($emailHash);
        if ($ignore != null) {
            return view('account.signup.registeredError');
        }

        // 現状のデータを取得
        $pr = Orm\UserProvisionalRegistration::find($email);
        if ($pr == null) {
            // 未登録なので新規に登録
            $pr = new Orm\UserProvisionalRegistration;
            $pr->email = $email;
        }

        // リミットは1日後
        $limitDate = new \DateTime();
        $limitDate->add(new \DateInterval('P1D'));
        $pr->limit_at = $limitDate->format('Y-m-d H:i:s');

        if ($pr->save()) {
            try {
                // メール送信
                Mail::to($email)
                    ->send(new ProvisionalRegistration($pr->token));
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                Log::error($e->getTraceAsString());

                return view('account.signup.mailError');
            }

            return view('account.signup.mailSent');
        } else {
            return view('common.systemError');
        }
    }

    /**
     * 登録画面
     *
     * @param string $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register($token)
    {
        if (!SignUp::validateToken($token)) {
            SignUp::deleteToken($token);
            return view('account.singup.tokenError');
        } else {
            $orm = Orm\UserProvisionalRegistration::where('token', $token)->first();
            return view('account.singup.register', [
                'pr' => $orm
            ]);
        }
    }

    /**
     * 本登録
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function registration(RegisterRequest $request)
    {
        $token = $request->get('token');

        if (!SignUp::validateToken($token)) {
            SignUp::deleteToken($token);
            return view('account.signup.tokenError');
        } else {
            SignUp::register($token, $request->get('name'), $request->get('password'));
            return view('account.signup.complete');
        }
    }
}
