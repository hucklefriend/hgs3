<?php

namespace Hgs3\Console\Commands\Master;

use Hgs3\Models\Game\SoftList;
use Illuminate\Console\Command;

class UpdateGameSoftList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'master:softlist';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update game soft list.';

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
        SoftList::generate();
    }
}
