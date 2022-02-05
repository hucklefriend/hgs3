<?php
/**
 * 新しいマスターデータ
 */

namespace Hgs3\Models\VersionUp;

use Hgs3\Models\Game\SoftList;
use Hgs3\Models\Orm\GameMaker;
use Hgs3\Models\Orm\GameOfficialSite;
use Hgs3\Models\Orm\GamePackage;
use Hgs3\Models\Orm\GamePackageLink;
use Hgs3\Models\Orm\GamePackageShop;
use Hgs3\Models\Orm\GamePlatform;
use Hgs3\Models\Orm\GameSeries;
use Hgs3\Models\Orm\GameSoft;
use Hgs3\Models\Site;
use Hgs3\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Master
{
    /**
     * インポート
     *
     * @param int $date
     * @throws \Exception
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function import($date)
    {
        echo 'import company.'.PHP_EOL;
        MasterImport\Company::import($date);

        echo 'import platform.'.PHP_EOL;
        MasterImport\Platform::import($date);

        echo 'import series.'.PHP_EOL;
        MasterImport\Series::import($date);

        echo 'import soft.'.PHP_EOL;
        MasterImport\Soft::import($date);

        echo 'import package.'.PHP_EOL;
        MasterImport\Package::import($date);

        echo 'import shop.'.PHP_EOL;
        MasterImport\Shop::import($date);

        echo 'import official site.' . PHP_EOL;
        MasterImport\OfficialSite::import($date);

        echo 'import sample image.' . PHP_EOL;
        MasterImport\SampleImage::import($date);

        echo 'update sort order.' . PHP_EOL;
        \Hgs3\Models\Orm\GameSoft::updateSortOrder();

        echo 'update game_package_shops release_int'. PHP_EOL;
        MasterImport\Package::updateShopReleaseInt();

        echo 'update shop image' . PHP_EOL;
        MasterImport\Package::updateShopImage();

        echo 'update soft first release int' . PHP_EOL;
        MasterImport\Package::updateFirstReleaseInt();

        echo 'update original package id.' . PHP_EOL;
        \Hgs3\Models\Game\Soft::updateOriginalPackageId(false);

        echo 'generate mongodb soft list' . PHP_EOL;
        SoftList::generate();
    }
}
