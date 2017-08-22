<?php
/**
 * ゲーム追加リクエストのテストデータ生成
 */

namespace Hgs3\Console\Commands\TestData;

use Illuminate\Console\Command;

class GameRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testdata:gamerequest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create test game request';

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
        \Hgs3\Models\Test\GameRequest::create();
    }
}
