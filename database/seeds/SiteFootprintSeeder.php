<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm;
use Hgs3\Models\Test;

class SiteFootprintSeeder extends Seeder
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

        $now = time();
        $start = $now - (86400 * 30 * 2);   // 2ヶ月前

        foreach ($sites as $site) {
            $num = rand(0, 1000);
            $time = $start;

            for ($i = 0; $i < $num; $i++) {
                $isGuest = rand(0, 10) < 5;
                if ($isGuest) {
                    $user = null;
                } else {
                    $user = $users[rand(0, $userMax)];
                }

                $time += rand(10, 86400);
                if ($time > $now) {
                    break;
                }

                \Hgs3\Models\Site\Footprint::add($site, $user, $time);
            }
        }
    }
}
