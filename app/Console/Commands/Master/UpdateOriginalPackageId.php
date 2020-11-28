<?php

namespace Hgs3\Console\Commands\Master;

use Illuminate\Console\Command;

class UpdateOriginalPackageId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'master:originalid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create test game community member';

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
        \Hgs3\Models\Game\Soft::updateOriginalPackageId(false);
    }
}
