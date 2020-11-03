<?php

use Illuminate\Database\Seeder;
use Hgs3\Models\Test;

class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = Test\User::get();
        $userMax = $users->count() - 1;

        foreach ($users as $user) {
            $num = rand(1, $userMax);
            for ($i = 0; $i < $num; $i++) {
                \Hgs3\Models\User\Follow::add($user, $users[rand(0, $userMax)]);
            }
        }
    }
}
