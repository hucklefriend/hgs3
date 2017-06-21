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
INSERT INTO game_platforms
SELECT
  id, `name`, hiragana, FROM_UNIXTIME(registered_date), FROM_UNIXTIME(updated_date)
FROM
  hgs2.hgs_g_hard
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`)
  , `hiragana` = VALUES(`hiragana`)
  , `created_at` = VALUES(`created_at`)
  , `updated_at` = VALUES(`updated_at`)
SQL;

        DB::insert($sql);
    }
}
