<?php
/**
 * パスワード忘れたコントローラー
 */

namespace Hgs3\Http\Controllers\Account;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Account\PasswordResetRequest;
use Hgs3\Http\Requests\Account\MailAuthRequest;
use Hgs3\Models\Account\PasswordReset;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ForgotController extends Controller
{
    /**
     * パスワード再設定
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('account.forgot');
    }

    /**
     * メール送信
     *
     * @param MailAuthRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function sendPasswordResetMail(MailAuthRequest $request)
    {
        $email = $request->get('email');

        // 登録されているメールアドレスか？
        $user = User::where('email', $email)->first();

        // メールアドレスが存在しない
        if (empty($user)) {
            return view('account.forgot.mailError');
        }

        // メール送信済みか？
        $passwordReset = Orm\PasswordReset::find($user->id);

        if ($passwordReset == null) {
            $passwordReset = new Orm\PasswordReset;
            $passwordReset->user_id = $user->id;
        } else {
            // 無視対象
            if ($passwordReset->ignore == 1) {
                return view('account.forgot.mailError');
            }
        }

        // トークン生成
        $passwordReset->token = md5($email . time());

        // リミットは1時間
        $limitDate = new \DateTime();
        $limitDate->add(new \DateInterval('PT1H'));
        $passwordReset->limit_at = $limitDate->format('Y-m-d H:i:s');

        if ($passwordReset->save()) {
            try {
                // メール送信
                Mail::to($email)
                    ->send(new \Hgs3\Mail\PasswordReset($passwordReset->token));
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                Log::error($e->getTraceAsString());

                return view('account.forgot.mailError');
            }

            return view('account.forgot.mailSent');
        } else {
            return view('common.systemError');
        }
    }

    /**
     * パスワード入力画面
     *
     * @param string $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reset($token)
    {
        if (!PasswordReset::validateToken($token)) {
            PasswordReset::deleteToken($token);
            return view('account.forgot.tokenError');
        } else {
            return view('account.forgot.reset', [
                'token' => $token
            ]);
        }
    }

    /**
     * 本登録
     *
     * @param PasswordResetRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(PasswordResetRequest $request)
    {
        $token = $request->get('token');

        if (!PasswordReset::validateToken($token)) {
            PasswordReset::deleteToken($token);
            return view('account.forgot.tokenError');
        } else {
            PasswordReset::reset($token, $request->get('password'));

            return view('account.forgot.complete');
        }
    }
}
