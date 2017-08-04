<?php

namespace Hgs3\Console\Commands\TestData;

use Illuminate\Console\Command;

class UserCommunityMember extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testdata:usercommunitymember';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create test user community member';

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
        \Hgs3\Models\Test\UserCommunityMember::create();
    }
}
