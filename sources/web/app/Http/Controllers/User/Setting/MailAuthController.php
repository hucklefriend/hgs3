<?php
/**
 * メール認証設定コントローラー
 */

namespace Hgs3\Http\Controllers\User\Setting;

use Hgs3\Constants\IconRoundType;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\User\Profile\ChangeIconImageRequest;
use Hgs3\Http\Requests\User\Profile\ChangeIconRoundRequest;
use Hgs3\Http\Requests\User\Profile\ConfigRequest;
use Hgs3\Http\Requests\User\Profile\EditRequest;
use Hgs3\Models\Account\SocialSite;
use Hgs3\Models\Orm;
use Hgs3\Models\Review;
use Hgs3\Models\Timeline;
use Hgs3\Models\User\Follow;
use Hgs3\Models\User\Profile;
use Hgs3\Models\User;
use Hgs3\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class MailAuthController extends Controller
{
    public function register()
    {
        // 登録済みかチェック


        return view('user.setting.mailAuth.register');
    }

    public function sendAuthMail()
    {
        // 登録済みかチェック

        return view('user.setting.mailAuth.sendAuthMail');
    }

    public function confirmAuth()
    {
        // 登録済みかチェック

        return view('user.setting.mailAuth.confirmAuth');
    }

    public function delete()
    {
        // 他のSNS認証があるかチェック



        $user = Auth::user();
        $user->email = null;
        $user->password = null;
        $user->save();

        return redirect()->route('ユーザー設定');
    }

    public function changeMail()
    {
        // メール認証設定済みかチェック
        return view('user.setting.mailAuth.changeMail');
    }

    public function sendChangeMail()
    {
        // メール認証設定済みかチェック
        return view('user.setting.mailAuth.sendChangeMail');
    }

    public function confirmMail()
    {
        // メール認証設定済みかチェック
        return view('user.setting.mailAuth.confirmMail');
    }

    public function changePassword()
    {
        // メール認証設定済みかチェック
        return view('user.setting.mailAuth.changePassword');
    }

    public function updatePassword()
    {
        // メール認証設定済みかチェック
        return view('user.setting.mailAuth.updatePassword');
    }
}
