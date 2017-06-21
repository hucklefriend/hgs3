<?php

namespace App\Models\VersionUp;
use Illuminate\Support\Facades\DB;

class Database
{
    public function version_up()
    {
        $this->copy_company();
        $this->copy_platform();
        $this->copy_series();
        $this->copy_soft();
    }

    /**
     * 会社マスターをコピー
     */
    private function copy_company()
    {
        $sql =<<< SQL
INSERT INTO game_companies
SELECT
  id, `name`, '', url, FROM_UNIXTIME(registered_date), FROM_UNIXTIME(updated_date)
FROM
  hgs2.hgs_g_company
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`)
  , `phonetic` = VALUES(`phonetic`)
  , `url` = VALUES(`url`)
  , `created_at` = VALUES(`created_at`)
  , `updated_at` = VALUES(`updated_at`)
SQL;

        DB::insert($sql);
    }

    /**
     * プラットフォームをコピー
     */
    private function copy_platform()
    {
        $sql =<<< SQL
INSERT INTO game_platforms
SELECT
  id, company_id, `name`, acronym, order_no, FROM_UNIXTIME(registered_date), FROM_UNIXTIME(updated_date)
FROM
  hgs2.hgs_g_hard
ON DUPLICATE KEY UPDATE
  `company_id` = VALUES(`company_id`)
  , `name` = VALUES(`name`)
  , `acronym` = VALUES(`acronym`)
  , `sort_order` = VALUES(`sort_order`)
  , `created_at` = VALUES(`created_at`)
  , `updated_at` = VALUES(`updated_at`)
SQL;

        DB::insert($sql);
    }

    /**
     * シリーズをコピー
     */
    private function copy_series()
    {
        $sql =<<< SQL
INSERT INTO game_series
SELECT
  id, `name`, hiragana, FROM_UNIXTIME(registered_date), FROM_UNIXTIME(updated_date)
FROM
  hgs2.hgs_g_series
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`)
  , `phonetic` = VALUES(`phonetic`)
  , `created_at` = VALUES(`created_at`)
  , `updated_at` = VALUES(`updated_at`)
SQL;

        DB::insert($sql);
    }

    private function copy_soft()
    {
        $sql =<<< SQL
INSERT INTO games
SELECT
  sf.id, sf.name, sf.hiragana, sf.genre_name, IF (sf.company_id <= 0, NULL, sf.company_id), sl.series_id, sl.order, sf.hiragana_type, NOW(), NOW()
FROM
  hgs2.hgs_g_soft sf LEFT OUTER JOIN hgs2.hgs_g_series_list sl ON sf.id = sl.soft_id
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`)
  , `phonetic` = VALUES(`phonetic`)
  , `genre` = VALUES(`genre`)
  , `company_id` = VALUES(`company_id`)
  , `series_id` = VALUES(`series_id`)
  , `order_in_series` = VALUES(`order_in_series`)
  , `sort_order` = VALUES(`sort_order`)
  , `created_at` = VALUES(`created_at`)
  , `updated_at` = VALUES(`updated_at`)
SQL;

        DB::insert($sql);
    }
}
