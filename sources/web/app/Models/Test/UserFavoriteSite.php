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
        $users = User::getIds();
        $userMax = count($users) - 1;

        $sites = Site::getIds();
        $fav = new FavoriteSite();

        foreach ($sites as $siteId) {
            $num = rand(0, $userMax);

            for ($i = 0; $i < $num; $i++) {
                $fav->add($users[rand(0, $userMax)], $siteId);
            }
        }
    }
}