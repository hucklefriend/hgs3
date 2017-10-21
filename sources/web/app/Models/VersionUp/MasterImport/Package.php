<?php
/**
 * パッケージインポート
 */


namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Constants\Game\Shop;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Package extends MasterImportAbstract
{
    /**
     * インポート
     */
    public function import()
    {
        //$this->update();

        $path = resource_path('master/package');

        $files = File::files($path);

        $companies = $this->getCompanyHash();
        $platforms = $this->getPlatformHash();

        foreach ($files as $filePath) {
            if (ends_with($filePath, 'update.php')) {
                continue;
            }

            \ChromePhp::info(File::basename($filePath));

            $data = \GuzzleHttp\json_decode(File::get($filePath), true);

            self::insert($data, $companies, $platforms);

            unset($data);
            unset($platform);
        }
    }

    /**
     * データ登録
     *
     * @param array $data
     * @param array $companies
     * @param array $platforms
     */
    public static function insert(array $data, array $companies, array $platforms)
    {
        \ChromePhp::info($data);

        foreach ($data['soft_id'] as $softId) {
            foreach ($data['packages'] as $pkg) {
                $package = new Orm\GamePackage;
                $package->name = $pkg['name'];
                $package->url = $pkg['url'];
                $package->release_date = $pkg['release_date'];
                $package->shop_id = Shop::getIdByName($pkg['shop']);
                if (isset($pkg['company']) && isset($companies[$pkg['company']])) {
                    $package->company_id = $companies[$pkg['company']] ?? null;
                }
                if (isset($pkg['platform']) && isset($platforms[$pkg['platform']])) {
                    $package->platform_id = $platforms[$pkg['platform']] ?? null;
                }

                if ($package->shop_id == Shop::AMAZON) {
                    $package->asin = $pkg['asin'];
                } else if ($package->shop_id != null){
                    $package->item_url = $pkg['shop_url'];
                }

                $package->save();

                DB::table('game_package_links')
                    ->insert([
                        'soft_id'    => $softId,
                        'package_id' => $package->id,
                        'sort_order' => $pkg['release_int']
                    ]);

                unset($package);
            }
        }
    }

    /**
     * データの更新
     */
    private function update()
    {
        $packages = include(resource_path('master/package/update.php'));

        foreach ($packages as $p) {
            $pkg = Orm\GamePackage::find($p['id']);

            $data = $p;
            unset($data['id']);
            $pkg->update($data);

            unset($data);
            unset($pkg);
        }

        unset($packages);
    }
}