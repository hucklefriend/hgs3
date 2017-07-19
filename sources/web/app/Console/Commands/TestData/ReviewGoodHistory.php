<?php

namespace Hgs3\Console\Commands\TestData;

use Hgs3\Models\Test\User;
use Illuminate\Console\Command;
use Hgs3\Models\VersionUp\Database;

class ReviewGoodHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testdata:rgh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create test user data';

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
     *
     * @return mixed
     */
    public function handle()
    {
        \Hgs3\Models\Test\ReviewGoodHistory::create(10);
    }
}
