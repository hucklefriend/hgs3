<?php
/**
 * フォロー
 */

namespace Hgs3\Models\Test;
use Hgs3\Models\User\FavoriteSite;
use Hgs3\Models\User\Follow;

class UserFollow
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create user follow test data.'.PHP_EOL;

        $users = User::getIds();
        $userMax = count($users) - 1;

        $follow = new Follow();

        foreach ($users as $user) {
            $num = rand(1, $userMax);
            for ($i = 0; $i < $num; $i++) {
                $follow->add($user, $users[rand(0, rand(0, $userMax))]);
            }
        }
    }
}