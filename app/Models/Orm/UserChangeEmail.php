<?php
/**
 * メール認証仮登録テーブル
 */

namespace Hgs3\Models\Orm;

class UserChangeEmail extends \Eloquent
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $guarded = ['user_id'];
}