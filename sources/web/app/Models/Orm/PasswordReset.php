<?php
/**
 * パスワードリセット
 */

namespace Hgs3\Models\Orm;

class PasswordReset extends \Eloquent
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $guarded = ['user_id'];
}