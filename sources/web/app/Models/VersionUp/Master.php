<?php
/**
 * 新しいマスターデータ
 */

namespace Hgs3\Models\VersionUp;
use Illuminate\Support\Facades\DB;

class Master
{
    /**
     * インポート
     */
    public function import()
    {
        echo 'import company.'.PHP_EOL;
        $company = new MasterImport\Company();
        $company->import();

        echo 'import platform.'.PHP_EOL;
        $platform = new MasterImport\Platform();
        $platform->import();

        echo 'import series.'.PHP_EOL;
        $series = new MasterImport\Series();
        $series->import();

        echo 'import soft.'.PHP_EOL;
        $soft = new MasterImport\Soft();
        $soft->import();

        echo 'import package.'.PHP_EOL;
        $package = new MasterImport\Package();
        $package->import();

        echo 'update sort order.'.PHP_EOL;
        \Hgs3\Models\Orm\GameSoft::updateSortOrder();
    }
}
