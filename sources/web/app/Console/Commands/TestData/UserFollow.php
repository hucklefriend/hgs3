<?php

namespace Hgs3\Console\Commands\TestData;

use Illuminate\Console\Command;

class UserFollow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testdata:userfollow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create test user follow data';

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
        \Hgs3\Models\Test\UserFollow::create();
    }
}
