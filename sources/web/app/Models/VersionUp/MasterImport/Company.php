<?php
/**
 * ゲーム会社インポート
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\File;

class Company extends MasterImportAbstract
{
    /**
     * 会社マスターのインポート
     */
    public function import()
    {
        // 既存データのアップデート
        $this->update();

        // 新規データの追加
        $path = resource_path('master/company');

        $files = File::files($path);
        foreach ($files as $filePath) {
            if (ends_with($filePath, 'update.php')) {
                continue;
            }

            $data = \GuzzleHttp\json_decode(File::get($filePath), true);

            $com = new Orm\GameCompany($data);
            $com->save();

            unset($data);
            unset($com);
        }
    }

    /**
     * データの更新
     */
    private function update()
    {
        $companies = include(resource_path('master/company/update.php'));

        foreach ($companies as $c) {
            $company = Orm\GameCompany::find($c['id']);

            $data = $c;
            unset($data['id']);
            $company->update($data);

            unset($data);
            unset($company);
        }

        unset($companies);
    }
}