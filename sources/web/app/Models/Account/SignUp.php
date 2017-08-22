<?php
/**
 * アカウントモデル
 */

namespace Hgs3\Models\Account;

use Hgs3\Mail\ProvisionalRegistration;
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
user_provisional_registrations (email, token, limit_date, create_at, updated_at)
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

        \Mail::to($email)
            ->send(new ProvisionalRegistration($email, $token));

        return true;
    }

    /**
     * トークンが有効か確認
     *
     * @param $email
     * @param $token
     * @return bool
     */
    public function validateToken($email, $token)
    {
        return DB::table('user_provisional_registrations')
            ->where('email', $email)
            ->where('token', $token)
            ->whereRaw('limit_date >= NOW()')
            ->count() == 1;
    }

    /**
     * 削除
     *
     * @param $email
     */
    public function deleteToken($email)
    {
        DB::table('user_provisional_registrations')
                ->where('email', $email)
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

    public function register($name, $email)
    {
        // 本登録
    }
}
