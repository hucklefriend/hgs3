<?php

namespace Hgs3\Console\Commands\TestData;

use Illuminate\Console\Command;
use Hgs3\Models\Test;

class All extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testdata:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create test data';

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
        Test\User::create(100);
        Test\Review::create(1000);
        Test\ReviewGoodHistory::create(10);
        Test\UserFavoriteGame::create();
        Test\Site::create();
        Test\UserFavoriteSite::create();

        Test\UserCommunity::create();
        Test\UserCommunityMember::create();
        Test\UserCommunityTopic::create();
        Test\UserCommunityTopicResponse::create();
    }
}
