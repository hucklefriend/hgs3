<?php

namespace Hgs3\Console\Commands\Master;

use Hgs3\Models\MongoDB\Collection;
use Hgs3\Models\VersionUp\Master;
use Illuminate\Console\Command;
use Hgs3\Models\VersionUp\Database;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'master:import {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'master import';

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
        $date = intval($this->argument('date'));
        Master::import($date);
    }
}
