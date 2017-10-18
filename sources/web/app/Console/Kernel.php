<?php

namespace Hgs3\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\VersionUpDatabase::class,
        Commands\TestData\All::class,
        Commands\TestData\User::class,
        Commands\TestData\UserPlayedGame::class,
        Commands\TestData\UserFavoriteGame::class,
        Commands\TestData\ReviewGoodHistory::class,
        Commands\TestData\Review::class,
        Commands\TestData\Site::class,
        Commands\TestData\UserFavoriteSite::class,
        Commands\TestData\UserFollow::class,
        Commands\TestData\UserCommunity::class,
        Commands\TestData\UserCommunityMember::class,
        Commands\TestData\UserCommunityTopic::class,
        Commands\TestData\UserCommunityTopicResponse::class,
        Commands\TestData\GameCommunityMember::class,
        Commands\TestData\GameCommunityTopic::class,
        Commands\TestData\GameCommunityTopicResponse::class,
        Commands\TestData\Timeline::class,
        Commands\TestData\NewInformation::class,
        Commands\Mongo\Reset::class,
        Commands\Init::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
