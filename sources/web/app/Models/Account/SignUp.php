<?php
/**
 * アカウントモデル
 */

namespace Hgs3\Models\Account;

use Hgs3\Mail\ProvisionalRegistration;
use Hgs3\Models\Orm\SocialAccount;
use Hgs3\Models\Orm\UserProvisionalRegistration;
use Hgs3\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SignUp
{
    /**
     * 仮登録メールを送信
     *
     * @param $email
     * @return bool
     */
    public function sendProvisionalRegistrationMail($email)
    {
        // トークンを生成
        $token = str_random(rand(10, 15));

        DB::beginTransaction();
        try {
            $sql =<<< SQL
INSERT IGNORE INTO
user_provisional_registrations (email, token, limit_date, created_at, updated_at)
VALUES (?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
SQL;

            $limitDate = new \DateTime();
            $limitDate->add(new \DateInterval('PT6H'));

            DB::insert($sql, [$email, $token, $limitDate]);

            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            DB::rollBack();

            return false;
        }
/*
        \Mail::to($email)
            ->send(new ProvisionalRegistration($email, $token));
*/
        return $token;
        // return true;
    }

    /**
     * トークンが有効か確認
     *
     * @param $email
     * @param $token
     * @return bool
     */
    public function validateToken($token)
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
    public function deleteToken($token)
    {
        DB::table('user_provisional_registrations')
                ->where('token', $token)
                ->delete();
    }

    /**
     * タイムリミットがきているトークンを削除
     */
    public function deleteTimeLimit()
    {
        DB::table('user_provisional_registrations')
            ->whereRaw('limit_date < NOW()')
            ->delete();
    }

    /**
     * 本登録
     *
     * @param string $token
     * @param string $name
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function register($token, $name, $password)
    {
        $orm = UserProvisionalRegistration::where('token', $token)
            ->first();

        DB::beginTransaction();
        try {
            \Hgs3\User::create([
                'name'     => $name,
                'email'    => $orm->email,
                'password' => bcrypt($password),
                'role'     => 1
            ]);

            $this->deleteToken($token);

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
     */
    public function registerBySocialite(\Laravel\Socialite\One\User $socialUser, $socialSiteId)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name'   => $socialUser->getName(),
            ]);

            $sa = new SocialAccount;

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
     */
    public function registerBySocialite2(\Laravel\Socialite\Two\User $socialUser, $socialSiteId)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name'   => $socialUser->getName(),
            ]);

            $sa = new SocialAccount;

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
