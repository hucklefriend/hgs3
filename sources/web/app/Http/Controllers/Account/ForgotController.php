<?php
/**
 * パスワード忘れたコントローラー
 */

namespace Hgs3\Http\Controllers\Account;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Account\RegisterRequest;
use Hgs3\Http\Requests\Account\SendPRMailRequest;
use Hgs3\Mail\PasswordReset;
use Hgs3\Mail\ProvisionalRegistration;
use Hgs3\Models\Account\SignUp;
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
     * @param SendPRMailRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function sendPasswordResetMail(SendPRMailRequest $request)
    {
        $email = $request->get('email');

        // 登録されているメールアドレスか？
        $user = User::where('email', $email)
            ->first();

        // メールアドレスが存在しない
        if (empty($user)) {
            return view('account.sendPasswordResetMailError');
        }

        // メール送信済みか？
        $passwordReset = Orm\PasswordReset::find($user->id);

        if ($passwordReset == null) {
            $passwordReset = new Orm\PasswordReset;
            $passwordReset->user_id = $user->id;
        } else {
            // 無視対象
            if ($passwordReset->ignore == 1) {
                return view('account.sendPasswordResetMailError');
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
                    ->send(new PasswordReset($passwordReset->token));
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                Log::error($e->getTraceAsString());

                return view('account.sendPasswordResetMailError');
            }

            return view('account.sendPRMail');
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
