<?php
/**
 * アカウントモデル
 */

namespace Hgs3\Models\Account;

use Hgs3\Constants\UserRole;
use Hgs3\Mail\ProvisionalRegistration;
use Hgs3\Models\User;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SignUp
{
    /**
     * トークンが有効か確認
     *
     * @param $email
     * @param $token
     * @return bool
     */
    public static function validateToken($token)
    {
        return DB::table('user_provisional_registrations')
            ->where('token', $token)
            ->whereRaw('limit_date >= NOW()')
            ->count() == 1;
    }

    /**
     * 削除
     *
     * @param string $token
     */
    public static function deleteToken($token)
    {
        DB::table('user_provisional_registrations')
                ->where('token', $token)
                ->delete();
    }

    /**
     * タイムリミットがきているトークンを削除
     */
    public static function deleteTimeLimit()
    {
        DB::table('user_provisional_registrations')
            ->whereRaw('limit_date < NOW()')
            ->delete();
    }

    /**
     * 本登録
     *
     * @param $token
     * @param $name
     * @param $password
     * @return bool
     * @throws \Exception
     */
    public static function register($token, $name, $password)
    {
        $orm = Orm\UserProvisionalRegistration::where('token', $token)
            ->first();

        DB::beginTransaction();
        try {
            // ユーザーテーブルに登録
            User::register([
                'name'     => $name,
                'email'    => $orm->email,
                'password' => bcrypt($password),
                'role'     => UserRole::USER
            ]);

            // 無視メールリストに登録
            Orm\IgnoreProvisionalRegistrations::ignoreInsert($orm->email);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return true;
    }

    /**
     * Socialiteでのユーザー登録
     *
     * @param \Laravel\Socialite\One\User $socialUser
     * @param $socialSiteId
     * @return bool
     * @throws \Exception
     */
    public static function registerBySocialite(\Laravel\Socialite\One\User $socialUser, $socialSiteId)
    {
        DB::beginTransaction();

        try {
            $user = User::register([
                'name'   => $socialUser->getName(),
            ]);

            $sa = new Orm\SocialAccount;

            $sa->user_id = $user->id;
            $sa->social_site_id = $socialSiteId;
            $sa->social_user_id = $socialUser->id;
            $sa->token = $socialUser->token;
            $sa->token_secret = $socialUser->tokenSecret;
            $sa->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return true;
    }

    /**
     * Socialiteでのユーザー登録
     *
     * @param \Laravel\Socialite\Two\User $socialUser
     * @param $socialSiteId
     * @return bool
     * @throws \Exception
     */
    public static function registerBySocialite2(\Laravel\Socialite\Two\User $socialUser, $socialSiteId)
    {
        DB::beginTransaction();

        try {
            $user = User::register([
                'name'   => $socialUser->getName(),
            ]);

            $sa = new Orm\SocialAccount;

            $sa->user_id = $user->id;
            $sa->social_site_id = $socialSiteId;
            $sa->social_user_id = $socialUser->id;
            $sa->token = $socialUser->token;
            $sa->token_secret = '';
            $sa->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return true;
    }
}
