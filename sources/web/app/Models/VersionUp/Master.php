<?php
/**
 * 新しいマスターデータ
 */

namespace Hgs3\Models\VersionUp;

use Hgs3\Models\Orm\GameCompany;
use Hgs3\Models\Orm\GameOfficialSite;
use Hgs3\Models\Orm\GamePackage;
use Hgs3\Models\Orm\GamePackageLink;
use Hgs3\Models\Orm\GamePackageShop;
use Hgs3\Models\Orm\GamePlatform;
use Hgs3\Models\Orm\GameSeries;
use Hgs3\Models\Orm\GameSoft;
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

        echo 'import official site.' . PHP_EOL;
        MasterImport\OfficialSite::import($date);

        echo 'update sort order.'.PHP_EOL;
        \Hgs3\Models\Orm\GameSoft::updateSortOrder();

        echo 'update original package id.' . PHP_EOL;
        \Hgs3\Models\Game\Soft::updateOriginalPackageId(false);
    }

    public static function importSql($date)
    {
        GameCompany::truncate();
        GameOfficialSite::truncate();
        GamePackage::truncate();
        GamePackageLink::truncate();
        GamePackageShop::truncate();
        GamePlatform::truncate();
        GameSeries::truncate();
        GameSoft::truncate();

        $path = storage_path('master/all/' . $date . '.sql');
        if (File::isFile($path)) {
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');
            $dbName = env('DB_DATABASE');

            $command = 'mysql -u ' . $dbUser;
            if (!empty($dbPass)) {
                $command .= ' -p ' . $dbPass;
            }
            $command .= ' ' . $dbName . ' < ' . escapeshellarg($path);
            exec($command);

            //DB::statement(File::get($path));
        }
    }
}
