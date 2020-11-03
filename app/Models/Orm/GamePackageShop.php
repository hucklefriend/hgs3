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
INSERT INTO game_package_shops (package_id, shop_id, shop_url, small_image_url, medium_image_url, large_image_url,
  param1, param2, param3, param4, param5, updated_timestamp, created_at, updated_at)
VALUES (:package_id, :shop_id, :shop_url, :small_image_url, :medium_image_url, :large_image_url,
  :param1, :param2, :param3, :param4, :param5, UNIX_TIMESTAMP(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
ON DUPLICATE KEY UPDATE
  shop_url = VALUES(shop_url)
  , small_image_url = VALUES(small_image_url)
  , medium_image_url = VALUES(medium_image_url)
  , large_image_url = VALUES(large_image_url)
  , param1 = VALUES(param1)
  , param2 = VALUES(param2)
  , param3 = VALUES(param3)
  , param4 = VALUES(param4)
  , param5 = VALUES(param5)
  , updated_timestamp = VALUES(updated_timestamp)
  , updated_at = CURRENT_TIMESTAMP 
SQL;

        DB::insert($sql, [
            'package_id' => $this->package_id,
            'shop_id'    => $this->shop_id,
            'shop_url'   => $this->shop_url,
            'small_image_url'   => $this->small_image_url,
            'medium_image_url'   => $this->medium_image_url,
            'large_image_url'   => $this->large_image_url,
            'param1'     => $this->param1,
            'param2'     => $this->param2,
            'param3'     => $this->param3,
            'param4'     => $this->param4,
            'param5'     => $this->param5
        ]);
    }
}
