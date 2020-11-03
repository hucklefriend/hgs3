<?php
/**
 * ORM: game_packages
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GamePackageLink extends \Eloquent
{
    protected $primaryKey = ['soft_id', 'package_id'];
    public $incrementing = false;

    /**
     * 重複していたら無視するINSERT
     *
     * @param $softId
     * @param $packageId
     * @param $sortOrder
     */
    public static function ignoreInsert($softId, $packageId, $sortOrder)
    {
        $sql =<<< SQL
INSERT IGNORE INTO game_package_links (soft_id, package_id, sort_order, created_at, updated_at)
VALUES (:soft_id, :package_id, :sort_order, CURRENT_TIMESTAMP , CURRENT_TIMESTAMP)
SQL;

        DB::insert($sql, [
            'soft_id'    => $softId,
            'package_id' => $packageId,
            'sort_order' => $sortOrder
        ]);
    }
}
