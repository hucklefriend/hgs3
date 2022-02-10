<?php
/**
 * マスター取り込みの基底クラス
 */

namespace Hgs3\Models\VersionUp\MasterImport;

use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;

abstract class MasterImportAbstract
{
    /**
     * ソフトのハッシュを取得
     *
     * @return array
     */
    protected static function getSoftHash()
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
    protected static function getCompanyHash()
    {
        return Orm\GameMaker::select(['id', 'acronym'])
            ->get()
            ->pluck('id', 'acronym')
            ->toArray();
    }

    /**
     * プラットフォームのハッシュを取得
     *
     * @return array
     */
    protected static function getPlatformHash()
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
    protected static function getSeriesHash()
    {
        return Orm\GameSeries::select(['id', 'name'])
            ->get()
            ->pluck('id', 'name')
            ->toArray();
    }

    /**
     * 名称からシリーズIDを取得
     *
     * @param $name
     * @return mixed
     */
    protected static function getSeriesId($name)
    {
        $sql = 'SELECT id FROM game_series WHERE `name` LIKE "%' . $name . '%"';

        $series = DB::select($sql);
        return $series[0]->id;
    }

    /**
     * 会社IDを取得
     *
     * @param string $name
     * @return mixed
     */
    protected static function getCompanyId($name)
    {
        $sql = 'SELECT id FROM game_companies WHERE name LIKE "%' . $name . '%"';

        $company = DB::select($sql);
        return $company[0]->id;
    }
}