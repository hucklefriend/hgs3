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
use Hgs3\Models\User;
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
        $data = [
            'name' => $request->get('name'),
            'password' => bcrypt($request->get('password')),
            'adult' => $request->get('adult', 0)
        ];

        if ($data['adult'] != 0) {
            $data['adult'] = 1;
        }

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

        $pr->user_data = \json_encode($data);

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
     * 登録完了
     *
     * @param string $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function register($token)
    {
        if (!SignUp::validateToken($token)) {
            SignUp::deleteToken($token);
            return view('account.signup.tokenError');
        } else {
            $orm = Orm\UserProvisionalRegistration::where('token', $token)->first();
            $userData = \json_decode($orm->user_data);
            $userData['email'] = $orm->email;

            // ユーザー情報を登録
            User::register($userData, false);

            return view('account.signup.complete');
        }
    }
}
