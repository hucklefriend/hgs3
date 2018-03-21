<?php
/**
 * 新しいマスターデータ
 */

namespace Hgs3\Models\VersionUp;

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
}
