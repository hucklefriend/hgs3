<?php
/**
 * ユーザーお気に入りサイトのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Hgs3\Models\User\FavoriteSite;

class UserFavoriteSite
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create user favorite site test data.'.PHP_EOL;

        $users = User::get();
        $userMax = $users->count() - 1;

        $sites = Site::get();
        $fav = new FavoriteSite();

        foreach ($sites as $site) {
            $num = rand(0, $userMax);

            for ($i = 0; $i < $num; $i++) {
                $fav->add($users[rand(0, $userMax)], $site);
            }
        }
    }
}