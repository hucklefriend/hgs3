<?php
/**
 *
 */


namespace Hgs3\Console\Commands\Mongo;

use Hgs3\Models\MongoDB\Collection;
use Illuminate\Console\Command;
use Hgs3\Models\VersionUp\Database;

class Reset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mongo:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reset MongoDB';

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
        Collection::create();
    }
}
