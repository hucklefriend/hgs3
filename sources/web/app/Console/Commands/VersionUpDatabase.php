<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VersionUp\Database;

class VersionUpDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'versionup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'copy data hgs2 to hgs3';

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
        $db = new Database;
        $db->version_up();
    }
}
