<?php

namespace Hgs3\Console;

use Hgs3\Log;
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
        Commands\Mongo\Reset::class,
        Commands\Init::class,
        Commands\Master\Import::class,
        Commands\Master\UpdateOriginalPackageId::class,
        Commands\Master\UpdateAffiliate::class,
        Commands\Master\UpdateShopImage::class,
        Commands\Sitemap::class,
        Commands\ReviewTotal::class,
        Commands\TranslateHgs::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('review:total')
                  ->hourly();

        $schedule->command('master:affiliate')
            ->dailyAt('04:00');
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
