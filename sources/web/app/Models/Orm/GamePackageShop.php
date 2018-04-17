<?php
/**
 * ORM: game_package_shops
 */

namespace Hgs3\Models\Orm;

use Illuminate\Support\Facades\DB;

class GamePackageShop extends \Eloquent
{
    protected $primaryKey = ['package_id', 'soft_id'];
    public $incrementing = false;
    protected $guarded = [];

    /**
     * INSERTしてみて重複していたらUPDATE
     */
    public function insertOrUpdate()
    {
        $sql =<<< SQL
INSERT INTO game_package_shops (package_id, shop_id, shop_url, param1, created_at, updated_at)
VALUES (:package_id, :shop_id, :shop_url, :param1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
ON DUPLICATE KEY UPDATE
  shop_url = VALUES(shop_url)
  , param1 = VALUES(param1)
  , updated_at = CURRENT_TIMESTAMP 
SQL;

        DB::insert($sql, [
            'package_id' => $this->package_id,
            'shop_id'    => $this->shop_id,
            'shop_url'   => $this->shop_url,
            'param1'     => $this->param1
        ]);
    }
}
