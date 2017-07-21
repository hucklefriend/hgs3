<?php

namespace Hgs3\Console\Commands\TestData;

use Illuminate\Console\Command;

class Review extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testdata:review';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create test review data';

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
        \Hgs3\Models\Test\Review::create(100);
    }
}
