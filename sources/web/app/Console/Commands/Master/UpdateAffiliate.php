<?php
/**
 * アフィリエイト情報の更新
 */


namespace Hgs3\Console\Commands\Master;

use Hgs3\Constants\Game\Shop;
use Illuminate\Console\Command;
use Hgs3\Models\Orm;

class UpdateAffiliate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'master:affiliate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update affiliate data';

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
        $shops = Orm\GamePackageShop::orderBy('updated_timestamp')
            ->take(10)
            ->get();

        foreach ($shops as $shop) {
            $this->info($shop->package_id . ' の更新中');

            if ($shop->shop_id == Shop::AMAZON) {
                \Hgs3\Models\Game\Package::saveImageByAsin($shop->package_id, $shop->param1);
            } else if ($shop->shop_id == Shop::DMM || $shop->shop_id == Shop::DMM_R18) {
                $pkg = Orm\GamePackage::find($shop->package_id);
                if ($pkg->shop_id != Shop::AMAZON) {
                    \Hgs3\Models\Game\Package::saveImageByDmm($shop->package_id, $shop->param1, $shop->shop_id);
                }
            } else {
                $shop->updated_timestamp = time();
                $shop->insertOrUpdate();
            }
        }
    }
}
