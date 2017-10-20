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
    }
}
