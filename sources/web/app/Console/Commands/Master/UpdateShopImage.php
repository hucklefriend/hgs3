<?php

namespace Hgs3\Console\Commands\Master;

use Hgs3\Models\VersionUp\MasterImport\Package;
use Illuminate\Console\Command;

class UpdateShopImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'master:shopimage';

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
        Package::updateShopImage();
    }
}
