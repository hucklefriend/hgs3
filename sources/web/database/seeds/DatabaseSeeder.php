<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            GameMasterSeeder::class,
            UserSeeder::class,
            FollowSeeder::class,
            SiteSeeder::class,
            SiteDailyAccessSeeder::class,
            SiteFootprintSeeder::class,
            SiteGoodSeeder::class,
            FavoriteGameSeeder::class,
            FavoriteSiteSeeder::class,
            ReviewSeeder::class
        ]);
    }
}
