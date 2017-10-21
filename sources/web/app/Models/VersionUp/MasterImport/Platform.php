<?php
/**
 * プラットフォームインポート
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\File;

class Platform extends MasterImportAbstract
{
    /**
     * インポート
     */
    public function import()
    {
        $this->update();

        $path = resource_path('master/platform');

        $files = File::files($path);

        $companies = $this->getCompanyHash();

        foreach ($files as $filePath) {
            if (ends_with($filePath, 'update.php')) {
                continue;
            }

            $data = \GuzzleHttp\json_decode(File::get($filePath), true);

            $data['company_id'] = $companies[$data['company']] ?? null;
            unset($data['company']);


            $platform = new Orm\GamePlatform($data);
            $platform->save();

            unset($data);
            unset($platform);
        }
    }

    /**
     * データの更新
     */
    private function update()
    {
        $platforms = include(resource_path('master/platform/update.php'));

        foreach ($platforms as $p) {
            $platform = Orm\GamePlatform::find($p['id']);

            $data = $p;
            unset($data['id']);
            $platform->update($data);

            unset($data);
            unset($company);
        }

        unset($platforms);
    }
}