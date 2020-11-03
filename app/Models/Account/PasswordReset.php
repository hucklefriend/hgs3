<?php
/**
 * パスワードリセットモデル
 */

namespace Hgs3\Models\Account;

use Hgs3\Models\User;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PasswordReset
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
        return DB::table('password_resets')
            ->where('token', $token)
            ->whereRaw('limit_at >= NOW()')
            ->count() == 1;
    }

    /**
     * 削除
     *
     * @param string $token
     */
    public static function deleteToken($token)
    {
        DB::table('password_resets')
                ->where('token', $token)
                ->delete();
    }

    /**
     * タイムリミットがきているトークンを削除
     */
    public static function deleteTimeLimit()
    {
        DB::table('password_resets')
            ->whereRaw('limit_at < NOW()')
            ->delete();
    }

    /**
     * パスワード再設定
     *
     * @param $token
     * @param $password
     * @return bool
     * @throws \Exception
     */
    public static function reset($token, $password)
    {
        $passwordReset = Orm\PasswordReset::where('token', $token)->first();
        $user = User::find($passwordReset->user_id);

        DB::beginTransaction();
        try {
            $user->password = bcrypt($password);
            $user->save();

            self::deleteToken($token);

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
