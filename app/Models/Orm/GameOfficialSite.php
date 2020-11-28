<?php
/**
 * ORM: game_official_site
 */

namespace Hgs3\Models\Orm;

use Illuminate\Support\Facades\DB;

class GameOfficialSite extends \Eloquent
{
    protected $primaryKey = ['soft_id', 'url'];
    protected $guarded = ['soft_id', 'url'];
    public $incrementing = false;

    public function save2()
    {
        $sql =<<< SQL
INSERT INTO game_official_sites (soft_id, title, url, priority, created_at, updated_at)
VALUES (:soft_id, :title, :url, :priority, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
ON DUPLICATE KEY UPDATE
  title = VALUES(title)
  , priority = VALUES(priority)
  , updated_at = CURRENT_TIMESTAMP
SQL;

        DB::insert($sql, [
            'soft_id'  => $this->soft_id,
            'title'    => $this->title,
            'url'      => $this->url,
            'priority' => $this->priority
        ]);
    }
}