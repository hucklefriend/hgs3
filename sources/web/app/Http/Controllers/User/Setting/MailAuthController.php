<?php
/**
 * メール認証設定コントローラー
 */

namespace Hgs3\Http\Controllers\User\Setting;

use Hgs3\Constants\User\Setting\MailChangeType;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Account\MailAuthRequest;
use Hgs3\Http\Requests\User\Setting\ChangeMailRequest;
use Hgs3\Http\Requests\User\Setting\ChangePasswordRequest;
use Hgs3\Log;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;


class MailAuthController extends Controller
{
    /**
     * メール認証設定
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register()
    {
        // 登録済みかチェック
        if (Auth::user()->isRegisteredMailAuth()) {
            return view('user.setting.mailAuth.alreadyRegistered');
        }

        return view('user.setting.mailAuth.register');
    }

    /**
     * メール認証の登録メール送信
     *
     * @param MailAuthRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function sendAuthMail(MailAuthRequest $request)
    {
        // 登録済みかチェック
        if (Auth::user()->isRegisteredMailAuth()) {
            return view('user.setting.mailAuth.alreadyRegistered');
        }

        // 仮登録
        $umc = Orm\UserChangeEmail::find(Auth::id());
        if ($umc == null) {
            $umc = new Orm\UserChangeEmail();
            $umc->user_id = Auth::id();
        }

        $umc->type = MailChangeType::REGISTER_MAIL_AUTH;
        $umc->email = $request->get('email');
        $umc->password = bcrypt($request->get('password'));
        $umc->token = str_random(8);
        $umc->save();

        // メール送信
        try {
            // メール送信
            Mail::to($umc->email)
                ->send(new \Hgs3\Mail\RegisterMailAuth($umc->token));
        } catch (\Exception $e) {
            Log::exceptionError($e);
            throw $e;
        }

        return view('user.setting.mailAuth.sendAuthMail');
    }

    /**
     * メール認証登録完了
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function confirmAuth()
    {
        // 登録済みかチェック
        $user = Auth::user();
        if ($user->isRegisteredMailAuth()) {
            return view('user.setting.mailAuth.alreadyRegistered');
        }

        // 仮登録テーブルチェック
        $umc = Orm\UserChangeEmail::find(Auth::id());
        if ($umc == null) {
            Log::warning('メール認証仮登録テーブルなし', ['user_id' => Auth::id()]);
            return view('user.setting.mailAuth.error', [
                'message' => 'メール認証設定が行われていません。'
            ]);
        }

        // タイムアップ
        if (strtotime($umc->updated_at) + 86400 < time()) {
            Log::warning('メール認証タイムアップ', ['user_id' => Auth::id()]);
            return view('user.setting.mailAuth.error', [
                'message' => 'メール送信から24時間以上経過したため、登録できません。'
            ]);
        }

        // トークンが合わない
        $token = Input::get('t', '');
        if ($token != $umc->token) {
            Log::warning('メール認証トークンエラー', [
                'user_id'   => Auth::id(),
                'req_token' => $token,
                'db_token'  => $umc->token
            ]);
            return view('user.setting.mailAuth.error', [
                'message' => 'トークンが一致しません。'
            ]);
        }

        // ユーザーテーブル更新
        $user->email = $umc->email;
        $user->password = $umc->password;
        $user->save();

        // 一時データ削除
        $umc->delete();

        return view('user.setting.mailAuth.confirmAuth');
    }

    /**
     * メール認証設定の削除
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete()
    {
        // 他のSNS認証があるかチェック
        $snsAuthNum = Orm\SocialAccount::query()
            ->where('user_id', Auth::id())
            ->count('user_id');
        if ($snsAuthNum == 0) {
            return view('user.setting.mailAuth.cannotDelete');
        }

        $user = Auth::user();
        $user->email = null;
        $user->password = null;
        $user->save();

        return redirect()->route('ユーザー設定');
    }

    /**
     * メールアドレス変更
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changeMail()
    {
        // メール認証の設定が先に行われている必要がある
        $user = Auth::user();
        if (!$user->isRegisteredMailAuth()) {
            return view('user.setting.mailAuth.notRegistered');
        }

        return view('user.setting.mailAuth.changeMail');
    }

    /**
     * メールアドレス変更確認メール送信
     *
     * @param ChangeMailRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function sendChangeMail(ChangeMailRequest $request)
    {
        // メール認証の設定が先に行われている必要がある
        $user = Auth::user();
        if (!$user->isRegisteredMailAuth()) {
            return view('user.setting.mailAuth.notRegistered');
        }

        // 仮登録
        $umc = Orm\UserChangeEmail::find(Auth::id());
        if ($umc == null) {
            $umc = new Orm\UserChangeEmail();
            $umc->user_id = Auth::id();
        }

        $umc->type = MailChangeType::CHANGE_MAIL_ADDRESS;
        $umc->email = $request->get('email');
        $umc->token = str_random(8);
        $umc->save();

        // メール送信
        try {
            // メール送信
            Mail::to($umc->email)
                ->send(new \Hgs3\Mail\ChangeMail($umc->token));
        } catch (\Exception $e) {
            Log::exceptionError($e);
            throw $e;
        }

        return view('user.setting.mailAuth.sendChangeMail');
    }

    /**
     * メールアドレス変更確定
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function confirmMail()
    {
        // メール認証の設定が先に行われている必要がある
        $user = Auth::user();
        if (!$user->isRegisteredMailAuth()) {
            return view('user.setting.mailAuth.notRegistered');
        }

        // 仮登録テーブルチェック
        $umc = Orm\UserChangeEmail::find(Auth::id());
        if ($umc == null) {
            Log::warning('メール変更仮登録テーブルなし', ['user_id' => Auth::id()]);
            return view('user.setting.mailAuth.error', [
                'message' => 'メールアドレス変更が行われていません。'
            ]);
        }

        // タイムアップ
        if (strtotime($umc->updated_at) + 86400 < time()) {
            Log::warning('メール変更タイムアップ', ['user_id' => Auth::id()]);
            return view('user.setting.mailAuth.error', [
                'message' => 'メール送信から24時間以上経過したため、変更できません。'
            ]);
        }

        // トークンが合わない
        $token = Input::get('t', '');
        if ($token != $umc->token) {
            Log::warning('メール変更トークンエラー', [
                'user_id'   => Auth::id(),
                'req_token' => $token,
                'db_token'  => $umc->token
            ]);
            return view('user.setting.mailAuth.error', [
                'message' => 'トークンが一致しません。'
            ]);
        }

        // ユーザーテーブル更新
        $user->email = $umc->email;
        $user->save();

        // 一時データ削除
        $umc->delete();

        return view('user.setting.mailAuth.confirmMail');
    }

    /**
     * パスワード変更
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePassword()
    {
        // メール認証の設定が先に行われている必要がある
        $user = Auth::user();
        if (!$user->isRegisteredMailAuth()) {
            return view('user.setting.mailAuth.notRegistered');
        }

        return view('user.setting.mailAuth.changePassword');
    }

    /**
     * パスワード変更処理
     *
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        // メール認証の設定が先に行われている必要がある
        $user = Auth::user();
        if (!$user->isRegisteredMailAuth()) {
            return view('user.setting.mailAuth.notRegistered');
        }

        $user->password = bcrypt($request->get('password'));
        $user->save();

        return view('user.setting.mailAuth.changePasswordComplete');
    }
}
