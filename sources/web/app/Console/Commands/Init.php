<?php

namespace Hgs3\Console\Commands;

use Hgs3\Models\Community\UserCommunity;
use Illuminate\Console\Command;
use Hgs3\Models\VersionUp\Database;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'initialize';

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
        UserCommunity::createDefaultCommunity();
    }
}
