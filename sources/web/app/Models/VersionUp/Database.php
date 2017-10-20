<?php

namespace Hgs3\Models\VersionUp;
use Hgs3\Models\Orm\UserCommunity;
use Illuminate\Support\Facades\DB;

class Database
{
    /**
     * バージョンアップ実行
     */
    public function versionUp()
    {
        $this->copyCompany();
        $this->copyPlatform();
        $this->copySeries();
        $this->copySoft();
        $this->copyPackage();

        $this->setOriginalPackageId();

        if (env('APP_ENV') == 'local') {
            $password = 'huckle';
        } else {
            $password = str_random(10);
            // パスワードをファイル出力
            $path = storage_path('app/admin_password.txt');
            echo 'admin password is '.$password.PHP_EOL;
            file_put_contents($path, $password);
        }

        // 管理人を作成
        \Hgs3\User::create([
            'name'     => 'huckle',
            'email'    => 'webmaster@horrorgame.net',
            'password' => bcrypt($password),
            'role'     => 100
        ]);

        $user = \Hgs3\User::find(1);
        $user->role = 100;
        $user->save();

        // 運営用ユーザーコミュニティを作成
        //UserCommunity::createDefault();
    }

    /**
     * 会社マスターをコピー
     */
    private function copyCompany()
    {
        $sql =<<< SQL
INSERT INTO game_companies
  (id, `name`, acronym, phonetic, url, wikipedia, created_at, updated_at)
SELECT
  id, `name`, `name`, '', url, '', FROM_UNIXTIME(registered_date), FROM_UNIXTIME(updated_date)
FROM
  hgs2.hgs_g_company
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`)
  , `acronym` = VALUES(`name`)
  , `phonetic` = VALUES(`phonetic`)
  , `url` = VALUES(`url`)
  , `updated_at` = VALUES(`updated_at`)
SQL;

        DB::insert($sql);
    }

    /**
     * プラットフォームをコピー
     */
    private function copyPlatform()
    {
        $sql =<<< SQL
INSERT INTO game_platforms
  (id, company_id, `name`, acronym, sort_order, created_at, updated_at)
SELECT
  id, company_id, `name`, acronym, order_no, FROM_UNIXTIME(registered_date), FROM_UNIXTIME(updated_date)
FROM
  hgs2.hgs_g_hard
ON DUPLICATE KEY UPDATE
  `company_id` = VALUES(`company_id`)
  , `name` = VALUES(`name`)
  , `acronym` = VALUES(`acronym`)
  , `sort_order` = VALUES(`sort_order`)
  , `updated_at` = VALUES(`updated_at`)
SQL;

        DB::insert($sql);
    }

    /**
     * シリーズをコピー
     */
    private function copySeries()
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
  , `updated_at` = VALUES(`updated_at`)
SQL;

        DB::insert($sql);
    }

    /**
     * ゲームソフトデータをコピー
     */
    private function copySoft()
    {
        $sql =<<< SQL
INSERT INTO game_softs
  
SELECT
  sf.id, sf.name, sf.hiragana, sf.hiragana_type, 0, sf.genre_name, 
  sl.series_id, sl.order, NULL, NOW(), NOW()
FROM
  hgs2.hgs_g_soft sf LEFT OUTER JOIN hgs2.hgs_g_series_list sl ON sf.id = sl.soft_id
WHERE
  sf.id NOT IN (91, 188)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`)
  , `phonetic` = VALUES(`phonetic`)
  , `phonetic_type` = VALUES(`phonetic_type`)
  , `genre` = VALUES(`genre`)
  , `series_id` = VALUES(`series_id`)
  , `order_in_series` = VALUES(`order_in_series`)
  , `updated_at` = NOW()
SQL;

        DB::insert($sql);
    }

    /**
     * パッケージをコピー
     */
    private function copyPackage()
    {
        $sql =<<< SQL
INSERT INTO game_packages
SELECT
	s.id, s.hard_id, IF(s.company_id <= 0, null, s.company_id),
	IF (other_name = '', ss.name, other_name), '', s.url,
	s.release_date, s.release_int,
	IF(s.game_type_id IN (1, 3), 0, 1),
	IF(a.asin IS NULL, null, 1),
	a.asin, a.item_url,
	a.small_image_url, a.small_image_width, a.small_image_height,
	a.medium_image_url, a.medium_image_width, a.medium_image_height,
	a.large_image_url, a.large_image_width, a.large_image_height,
	FROM_UNIXTIME(s.registered_date), FROM_UNIXTIME(s.updated_date)
FROM
	hgs2.hgs_g_soft_detail s
	LEFT OUTER JOIN hgs2.hgs_g_soft ss ON s.soft_id = ss.id
	LEFT OUTER JOIN hgs2.hgs_g_amazon a ON s.asin = a.asin
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`)
  , `game_id` = VALUES(`game_id`)
  , `platform_id` = VALUES(`platform_id`)
  , `company_id` = VALUES(`company_id`)
  , `url` = VALUES(`url`)
  , `release_date` = VALUES(`release_date`)
  , `release_int` = VALUES(`release_int`)
  , `game_type_id` = VALUES(`game_type_id`)
  , `asin` = VALUES(`asin`)
  , `item_url` = VALUES(`item_url`)
  , `small_image_url` = VALUES(`small_image_url`)
  , `small_image_width` = VALUES(`small_image_width`)
  , `small_image_height` = VALUES(`small_image_height`)
  , `medium_image_url` = VALUES(`medium_image_url`)
  , `medium_image_width` = VALUES(`medium_image_width`)
  , `medium_image_height` = VALUES(`medium_image_height`)
  , `large_image_url` = VALUES(`large_image_url`)
  , `large_image_width` = VALUES(`large_image_width`)
  , `large_image_height` = VALUES(`large_image_height`)
  , `updated_at` = VALUES(`updated_at`)
SQL;

        DB::insert($sql);
    }

    /**
     * ベースとなるパッケージIDをgamesに登録
     */
    public function setOriginalPackageId()
    {
        $games = DB::select('SELECT id FROM game_softs');

        foreach ($games as $game) {
            $package = DB::select('SELECT id FROM game_packages WHERE game_id = ? ORDER BY release_int, id', [$game->id]);

            if (!empty($package)) {
                DB::table('games')
                    ->where('id', $game->id)
                    ->update([
                        'original_package_id' => $package[0]->id
                    ]);
            }

            unset($package);
        }
    }
}
