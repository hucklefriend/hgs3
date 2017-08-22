<?php
/**
 * ゲーム追加リクエストのコメントのテストデータ生成
 */

namespace Hgs3\Console\Commands\TestData;

use Illuminate\Console\Command;

class GameRequestComment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testdata:gamerequestcomment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create test game request comment';

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
        \Hgs3\Models\Test\GameRequestComment::create();
    }
}
