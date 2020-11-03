<?php
/**
 * ユーザー仮登録
 */

namespace Hgs3\Models\Orm;

class UserProvisionalRegistration extends \Eloquent
{
    protected $primaryKey = 'email';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = ['email'];

    /**
     * データの保存
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        // 最大10回まで繰り返す
        for ($i = 0; $i < 10; $i++) {
            $this->token = self::generateToken();

            try {
                return parent::save($options);
            } catch (\Exception $e) {}
        }

        return false;
    }

    /**
     * トークンを生成
     *
     * @return string
     */
    private static function generateToken()
    {
        return str_random(15);
    }
}
