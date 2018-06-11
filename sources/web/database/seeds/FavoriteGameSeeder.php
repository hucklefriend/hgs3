<?php

use Illuminate\Database\Seeder;
use Hgs3\Models\Test;

class FavoriteGameSeeder extends Seeder
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
        if ($userMax > 100) {
            $userMax = 100;
        }

        $games = Test\GameSoft::get();

        foreach ($games as $game) {
            $num = rand(0, $userMax);

            for ($i = 0; $i < $num; $i++) {
                \Hgs3\Models\User\FavoriteSoft::add($users[rand(0, $userMax)], $game);
            }
        }

        unset($users);
        unset($games);
    }
}
