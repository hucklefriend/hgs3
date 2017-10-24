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
        $company = new MasterImport\Company();
        $company->import();

        $platform = new MasterImport\Platform();
        $platform->import();

        $series = new MasterImport\Series();
        $series->import();

        $soft = new MasterImport\Soft();
        //$soft->import();

        $package = new MasterImport\Package();
        //$package->import();

        \Hgs3\Models\Orm\GameSoft::updateSortOrder();
    }
}
