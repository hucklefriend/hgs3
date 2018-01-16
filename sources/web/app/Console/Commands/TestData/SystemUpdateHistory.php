<?php

namespace Hgs3\Console\Commands\TestData;

use Illuminate\Console\Command;

class SystemUpdateHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testdata:systemupdatehistory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create test system update history data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Hgs3\Models\Test\SystemUpdateHistory::create(100);
    }
}
