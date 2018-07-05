<?php

namespace Hgs3\Console\Commands;

use Illuminate\Console\Command;

class UserSearchIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:search_index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'user_search_index';

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
     * @throws \Exception
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        \Hgs3\Models\Review\Total::total();
    }
}
