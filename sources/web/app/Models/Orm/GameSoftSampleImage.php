<?php
/**
 * ORM: game_soft_sample_images
 */

namespace Hgs3\Models\Orm;

use Illuminate\Support\Facades\DB;

class GameSoftSampleImage extends \Eloquent
{
    protected $primaryKey = ['soft_id', 'no'];
    protected $guarded = ['soft_id', 'no'];
    public $incrementing = false;

    public function upsert()
    {
        $sql =<<< SQL
INSERT INTO game_soft_sample_images (`no`, package_id, shop_id, small_image_url, large_image_url, created_at, updated_at)
VALUES (:no, :package_id, :shop_id, :small_image_url, :large_image_url, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
ON DUPLICATE KEY UPDATE
  package_id = VALUES(package_id)
  , shop_id = VALUES(shop_id)
  , small_image_url = VALUES(small_image_url)
  , large_image_url = VALUES(large_image_url)
  , updated_at = CURRENT_TIMESTAMP
SQL;

        DB::insert($sql, [
            'no'              => $this->no,
            'package_id'      => $this->package_id,
            'shop_id'         => $this->shop_id,
            'small_image_url' => $this->small_image_url,
            'large_image_url' => $this->large_image_url
        ]);
    }
}