<?php

use Illuminate\Database\Seeder;
use Hgs3\Models\Test;

class SiteGoodSeeder extends Seeder
{
    /**
     * サイトデータ生成
     *
     * @throws Exception
     */
    public function run()
    {
        $users = Test\User::get();
        $userMax = $users->count() - 1;

        $sites = Test\Site::get();
        foreach ($sites as $site) {
            $num = rand(0, $userMax);

            for ($i = 0; $i < $num; $i++) {
                $user = $users[rand(0, $userMax)];
                if (!\Hgs3\Models\Site\Good::isGood($site, $user)) {
                    \Hgs3\Models\Site\Good::good($site, $user);
                }
            }
        }
    }
}
