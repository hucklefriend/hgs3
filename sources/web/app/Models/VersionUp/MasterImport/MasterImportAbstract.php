<?php
/**
 * マスター取り込みの基底クラス
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;

abstract class MasterImportAbstract
{
    /**
     * ソフトのハッシュを取得
     *
     * @return array
     */
    protected function getSoftHash()
    {
        return Orm\GameSoft::select(['id', 'name'])
            ->get()
            ->pluck('id', 'name')
            ->toArray();
    }

    /**
     * 会社のハッシュを取得
     *
     * @return array
     */
    protected function getCompanyHash()
    {
        return Orm\GameCompany::select(['id', 'acronym'])
            ->get()
            ->pluck('id', 'acronym')
            ->toArray();
    }

    /**
     * プラットフォームのハッシュを取得
     *
     * @return array
     */
    protected function getPlatformHash()
    {
        return Orm\GamePlatform::select(['id', 'acronym'])
            ->get()
            ->pluck('id', 'acronym')
            ->toArray();
    }

    /**
     * シリーズのハッシュを取得
     *
     * @return array
     */
    protected function getSeriesHash()
    {
        return Orm\GameSeries::select(['id', 'name'])
            ->get()
            ->pluck('id', 'name')
            ->toArray();
    }
}