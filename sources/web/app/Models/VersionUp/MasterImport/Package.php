<?php
/**
 * パッケージインポート
 */


namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Constants\Game\Shop;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\File;

class Package extends MasterImportAbstract
{
    /**
     * インポート
     */
    public function import()
    {
        //$this->update();

        $path = resource_path('master/platform');

        $files = File::files($path);

        $companies = $this->getCompanyHash();
        $platforms = $this->getPlatformHash();

        foreach ($files as $filePath) {
            if (ends_with($filePath, 'update.php')) {
                continue;
            }

            $data = \GuzzleHttp\json_decode(File::get($filePath), true);

            $data['company_id'] = $companies[$data['company']] ?? null;
            unset($data['company']);

            self::insert($data, $companies, $platforms);



            unset($data);
            unset($platform);
        }
    }

    public static function insert(array $data, array $companies, array $platforms)
    {
        $package = new Orm\GamePackage;

        $package->game_id = $data->game_id;
        $package->name = $data->name;
        $package->url = $data->url;
        $package->release_date = $data->release_date;
        $package->release_int = $data->release_int;
        $package->shop_id = Shop::getIdByName($data->shop);

        if ($package->shop_id == Shop::AMAZON) {
            //$package->item_url = $data->game_id;
        } else if ($package->shop_id != null){
            $package->item_url = $data->shop_url;
        }

        $package->game_id = $data->game_id;
        $package->game_id = $data->game_id;


        $package->save();
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