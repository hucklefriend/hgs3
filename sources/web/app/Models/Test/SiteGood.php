<?php
/**
 * ユーザーお気に入りサイトのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Hgs3\Models\Site\Good;

class SiteGood
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create site good test data.'.PHP_EOL;

        $users = User::get();
        $userMax = $users->count() - 1;

        $sites = Site::get();
        $good = new Good();

        foreach ($sites as $site) {
            $num = rand(0, $userMax);

            for ($i = 0; $i < $num; $i++) {
                $user = $users[rand(0, $userMax)];
                if (!$good->isGood($site, $user)) {
                    $good->good($site, $user);
                }
            }
        }
    }
}