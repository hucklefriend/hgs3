<?php
/**
 * 仮登録無視メールアドレス
 */

namespace Hgs3\Models\Orm;

use Illuminate\Support\Facades\DB;

class IgnoreProvisionalRegistrations extends \Eloquent
{
    protected $primaryKey = 'email_hash';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = ['email_hash'];

    /**
     * DBに登録(重複は無視)
     *
     * @param $mail
     */
    public static function ignoreInsert($mail)
    {
        $sql =<<< SQL
INSERT IGNORE INTO ignore_provisional_registrations (email_hash, created_at, updated_at)
VALUES (?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
SQL;

        DB::insert($sql, [md5($mail)]);
    }

    /**
     * 変更
     *
     * @param $oldEmail
     * @param $newEmail
     * @throws \Exception
     */
    public static function change($oldEmail, $newEmail)
    {
        self::where('email_hash', md5($oldEmail))
            ->delete();

        self::ignoreInsert($newEmail);
    }
}