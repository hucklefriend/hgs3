<?php

namespace Hgs3\Console\Commands;

use Hgs3\Models\MongoDB\Collection;
use Hgs3\Models\Orm\GameCompany;
use Hgs3\Models\Orm\GamePlatform;
use Hgs3\Models\Orm\GameSeries;
use Hgs3\Models\Orm\GameSoft;
use Hgs3\Models\VersionUp\Master;
use Illuminate\Console\Command;
use Hgs3\Models\VersionUp\Database;

class ReviewTotal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'review:total';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reviews';

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

    }
}
