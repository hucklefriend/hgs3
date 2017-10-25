<?php
/**
 * ユーザーお気に入りサイトのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Hgs3\Models\Site\Footprint;

class SiteFootprint
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create site footprint test data.'.PHP_EOL;

        $users = User::get();
        $userMax = $users->count() - 1;

        $sites = Site::get();

        foreach ($sites as $site) {
            $num = rand(0, 10000);

            for ($i = 0; $i < $num; $i++) {
                $isGuest = rand(0, 10) < 5;
                if ($isGuest) {
                    $user = null;
                } else {
                    $user = $users[rand(0, $userMax)];
                }

                Footprint::add($site, $users[rand(0, $userMax)]);
            }
        }
    }
}