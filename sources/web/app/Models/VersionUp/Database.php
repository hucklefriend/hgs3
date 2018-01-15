<?php

namespace Hgs3\Models\VersionUp;
use Hgs3\Constants\Game\Shop;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Support\Facades\DB;

class Database
{
    /**
     * バージョンアップ実行
     */
    public function versionUp()
    {
        echo 'copy company'.PHP_EOL;
        $this->copyCompany();
        echo 'copy platform'.PHP_EOL;
        $this->copyPlatform();
        echo 'copy series'.PHP_EOL;
        $this->copySeries();
        echo 'copy soft'.PHP_EOL;
        $this->copySoft();
        echo 'copy package'.PHP_EOL;
        $this->copyPackage();

        echo 'copy original package id'.PHP_EOL;
        $this->setOriginalPackageId();

        echo 'generate password'.PHP_EOL;
        if (env('APP_ENV') == 'local') {
            $password = 'huckle';
        } else {
            $password = str_random(10);
            // パスワードをファイル出力
            $path = storage_path('app/admin_password.txt');
            echo 'admin password is '.$password.PHP_EOL;
            file_put_contents($path, $password);
        }

        echo 'create admin'.PHP_EOL;
        // 管理人を作成
        User::register([
            'name'     => 'huckle',
            'email'    => 'webmaster@horrorgame.net',
            'password' => $password,
            'role'     => 100
        ]);

        // 運営用ユーザーコミュニティを作成
        //UserCommunity::createDefault();
    }

    /**
     * 会社マスターをコピー
     */
    private function copyCompany()
    {
        DB::table('game_companies')->truncate();

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
        DB::table('game_platforms')->truncate();

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
        DB::table('game_series')->truncate();

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
        DB::table('game_softs')->truncate();

        $sql =<<< SQL
INSERT INTO game_softs (
  id, name, phonetic, phonetic_type, phonetic_order, genre,
  series_id, order_in_series, original_package_id, created_at, updated_at
)
SELECT
  sf.id, sf.name, sf.hiragana, sf.hiragana_type, 0, sf.genre_name, 
  sl.series_id, sl.order, NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
FROM
  hgs2.hgs_g_soft sf LEFT OUTER JOIN hgs2.hgs_g_series_list sl ON sf.id = sl.soft_id
WHERE
  sf.id NOT IN (91, 188, 260, 261, 262)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`)
  , `phonetic` = VALUES(`phonetic`)
  , `phonetic_type` = VALUES(`phonetic_type`)
  , `genre` = VALUES(`genre`)
  , `series_id` = VALUES(`series_id`)
  , `order_in_series` = VALUES(`order_in_series`)
  , `updated_at` = CURRENT_TIMESTAMP
SQL;

        DB::insert($sql);
    }

    /**
     * パッケージをコピー
     */
    private function copyPackage()
    {
        DB::table('game_packages')->truncate();
        DB::table('game_package_shops')->truncate();
        DB::table('game_package_links')->truncate();

        $sql =<<< SQL
SELECT
    ss.id soft_id
	, s.id package_id
	, s.hard_id platform_id
	, s.short_name
	, IF(s.company_id <= 0, null, s.company_id) company_id
	, IF (other_name = '', ss.name, other_name) `name`
	, s.url
	, s.release_date
	, s.release_int
	, IF(s.game_type_id IN (1, 3), 0, 1) is_adult
	, IF(a.asin IS NULL, null, 1) shop_id
	, a.asin
	, a.item_url,
	a.small_image_url, a.small_image_width, a.small_image_height,
	a.medium_image_url, a.medium_image_width, a.medium_image_height,
	a.large_image_url, a.large_image_width, a.large_image_height,
	CURRENT_TIMESTAMP created_at, CURRENT_TIMESTAMP updated_at
FROM
	hgs2.hgs_g_soft_detail s
	LEFT OUTER JOIN hgs2.hgs_g_soft ss ON s.soft_id = ss.id
	LEFT OUTER JOIN hgs2.hgs_g_amazon a ON s.asin = a.asin
WHERE
  ss.id NOT IN (91, 188, 260, 261, 262)
SQL;

        $data = DB::select($sql);

        $nameHash = [];
        foreach ($data as $row) {
            $key = $row->platform_id . $row->release_int . $row->asin . $row->short_name;
            $nameHash[$key][] = $row;
        }

        foreach ($nameHash as $packages) {
            $row = $packages[0];

            DB::table('game_packages')
                ->insert([
                    'id'                  => $row->package_id,
                    'platform_id'         => $row->platform_id,
                    'company_id'          => $row->company_id,
                    'name'                => $row->name,
                    'url'                 => $row->url,
                    'release_int'         => $row->release_int,
                    'release_at'          => $row->release_date,
                    'is_adult'            => $row->is_adult,
                    'small_image_url'     => $row->small_image_url,
                    'small_image_width'   => $row->small_image_width,
                    'small_image_height'  => $row->small_image_height,
                    'medium_image_url'    => $row->medium_image_url,
                    'medium_image_width'  => $row->medium_image_width,
                    'medium_image_height' => $row->medium_image_height,
                    'large_image_url'     => $row->large_image_url,
                    'large_image_width'   => $row->large_image_width,
                    'large_image_height'  => $row->large_image_height,
                    'created_at'          => $row->created_at,
                    'updated_at'          => $row->updated_at
                ]);

            // H.G.S.2ではショップはAmazonのみだったのでバージョンアップではAmazonしかありえない
            if ($row->asin !== null) {
                DB::table('game_package_shops')
                    ->insert([
                        'package_id' => $row->package_id,
                        'shop_id'    => Shop::AMAZON,
                        'shop_url'   => $row->item_url,
                        'param1'     => $row->asin
                    ]);
            }

            foreach ($packages as $pkg) {
                DB::table('game_package_links')
                    ->insert([
                        'soft_id'    => $pkg->soft_id,
                        'package_id' => $row->package_id,
                        'sort_order' => $pkg->release_int,
                        'created_at' => $row->created_at,
                        'updated_at' => $row->updated_at
                    ]);
            }
        }

        unset($data);
        unset($nameHash);
    }

    /**
     * ベースとなるパッケージIDをgamesに登録
     */
    public function setOriginalPackageId()
    {
        $softs = Orm\GameSoft::all();

        foreach ($softs as $soft) {
            $link = DB::table('game_package_links')
                ->select(['package_id'])
                ->where('soft_id', $soft->id)
                ->orderBy('sort_order')
                ->orderBy('package_id')
                ->first();

            if (!empty($link)) {
                $soft->original_package_id = $link->package_id;
                $soft->save();
            }

            unset($link);
        }
    }
}
