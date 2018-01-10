<?php

namespace Hgs3\Console\Commands\Batch;

use Hgs3\Models\Account\SignUp;
use Hgs3\Models\Site\NewArrival;
use Illuminate\Console\Command;

class Daily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'daily batch';

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
        // 直近30日間のアクセス数
        $this->info('start site 30days access ranking');

        // 登録日が30日以上前の新着サイトを削除
        $this->info('delete old new arrival site.');
        if (!NewArrival::deleteOld()) {
            $this->error('error!! NewArrival::deleteOld');
        }

        // タイムリミットが過ぎた仮登録データを削除
        $this->info('delete time limit pr token');
        SignUp::deleteTimeLimit();
    }
}
