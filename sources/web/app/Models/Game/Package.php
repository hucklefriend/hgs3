<?php
/**
 * ゲームソフトモデル
 */

namespace Hgs3\Models\Game;

use Hgs3\Constants\Game\Shop;
use Hgs3\Log;
use Hgs3\Models\Game\Shop\Amazon;
use Hgs3\Models\Game\Shop\Dmm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm;

class Package
{
    /**
     * データ登録
     *
     * @param Orm\GameSoft $soft
     * @param Orm\GamePackage $package
     * @param string $asin
     * @throws \Exception
     */
    public static function insert(Orm\GameSoft $soft, Orm\GamePackage $package, $asin)
    {
        $amazonData = null;
        if (!empty($asin)) {
            $amazonData = Amazon::getData($asin);
            if (!empty($amazonData)) {
                $package->setImageByAmazon($amazonData);
            }
        }

        DB::beginTransaction();
        try {
            $package->save();
            self::link($soft, $package);

            if (!empty($asin)) {
                if (!empty($amazonData)) {
                    self::saveShop($package->id, Shop::AMAZON, $amazonData['shop_url'],
                        $amazonData['small_image']['url'] ?? null, $amazonData['medium_image']['url'] ?? null,
                        $amazonData['large_image']['url'] ?? null, $asin);
                } else {
                    self::saveShop($package->id, Shop::AMAZON, '', null, null, null, $asin);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);
        }
    }

    /**
     * データ更新
     *
     * @param Orm\GameSoft $soft
     * @param Orm\GamePackage $package
     * @param string $asin
     * @throws \Exception
     */
    public static function update(Orm\GameSoft $soft, Orm\GamePackage $package, $asin)
    {
        $amazonData = null;
        if (!empty($asin)) {
            $amazonData = Amazon::getData($asin);
            if (!empty($amazonData)) {
                $package->setImageByAmazon($amazonData);
            }
        }

        DB::beginTransaction();
        try {
            // ショップ情報を一回削除
            Orm\GamePackageShop::where('package_id', $package->id)
                ->delete();

            $package->save();
            if (!empty($asin)) {
                if (!empty($amazonData)) {
                    self::saveShop($package->id, Shop::AMAZON, $amazonData['shop_url'],
                        $amazonData['small_image']['url'] ?? null, $amazonData['medium_image']['url'] ?? null,
                        $amazonData['large_image']['url'] ?? null, $asin);
                } else {
                    self::saveShop($package->id, Shop::AMAZON, '', null, null, null, $asin);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);
        }
    }

    /**
     * パッケージ削除
     *
     * @param Orm\GameSoft $soft
     * @param Orm\GamePackage $package
     * @throws \Exception
     */
    public static function delete(Orm\GameSoft $soft, Orm\GamePackage $package)
    {
        DB::beginTransaction();
        try {
            // ショップ情報を削除
            Orm\GamePackageShop::where('package_id', $package->id)
                ->delete();

            // ソフトとの関連付けを削除
            Orm\GamePackageLink::where('soft_id', $soft->id)
                ->where('package_id', $package->id)
                ->delete();

            // TODO レビューの削除
            // TODO 遊んだゲームの削除

            // パッケージを削除
            $package->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::exceptionError($e);
        }
    }

    /**
     * パッケージとソフトの関連付け
     *
     * @param Orm\GameSoft $soft
     * @param Orm\GamePackage $package
     */
    public static function link(Orm\GameSoft $soft, Orm\GamePackage $package)
    {
        $sql =<<< SQL
INSERT IGNORE INTO game_package_links (
  soft_id, package_id, sort_order, created_at, updated_at
) VALUES (
  ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP 
)
SQL;

        DB::insert($sql, [$soft->id, $package->id, $package->release_int]);
    }

    /**
     * パッケージのショップデータを取得
     *
     * @param array $packageIds
     * @return array
     */
    public static function getShopData(array $packageIds)
    {
        $data = DB::table('game_package_shops')
            ->select(['package_id', 'shop_id', 'shop_url'])
            ->whereIn('package_id', $packageIds)
            ->get();

        $hash = [];
        foreach ($data as $row) {
            $hash[intval($row->package_id)][] = $row;
        }

        unset($data);

        return $hash;
    }

    /**
     * Amazonの商品情報からデータを更新
     *
     * @param array $packageIds
     */
    public static function updateFromAmazon($packageIds = [])
    {
        $select = DB::table('game_package_shops')
            ->select(['package_id', 'param1']);

        if (!empty($packageIds)) {
            $select->where('package_id', 'IN', $packageIds);
        }

        $data = $select->where('shop_id', Shop::AMAZON)
            ->get();

        foreach ($data as $shopData) {
            self::saveImageByAsin($shopData->package_id, $shopData->param1);
        }
    }

    /**
     * ASINからデータを保存
     *
     * @param int $packageId
     * @param string $asin
     */
    public static function saveImageByAsin($packageId, $asin)
    {
        $item = Amazon::getData($asin);

        if (empty($item)) {
            self::saveShop($packageId, Shop::AMAZON, '', null, null, null, $asin);
        } else {
            self::saveImageData($packageId, Shop::AMAZON, $item);
            self::saveShop($packageId, Shop::AMAZON, $item['shop_url'],
                $item['small_image']['url'] ?? null, $item['medium_image']['url'] ?? null, $item['large_image']['url'] ?? null, $asin);
        }
    }

    /**
     * DMMからデータを保存
     *
     * @param $packageId
     * @param $cid
     * @param $shopId
     */
    public static function saveImageByDmm($packageId, $cid, $shopId)
    {
        $shop = $shopId == Shop::DMM_R18 ? 'DMM.R18' : 'DMM.com';
        $item = Dmm::getItem($cid, $shop);

        if ($item === false || $item->result->total_count == 0) {
            echo 'package id: ' . $packageId . ' is nothing in DMM(' . $shopId . ')' . PHP_EOL;
            self::saveShop($packageId, $shopId, '', null, null, null, $cid);
        } else {
            $img = [
                'small_image'  => ['url' => $item->result->items[0]->imageURL->list ?? null],
                'medium_image' => ['url' => $item->result->items[0]->imageURL->small ?? null],
                'large_image'  => ['url' => $item->result->items[0]->imageURL->large ?? null]
            ];

            self::saveImageData($packageId, $shopId, $img);
            self::saveShop($packageId, $shopId,
                $item->result->items[0]->affiliateURL ?? $item->result->items[0]->URL,
                $img['small_image']['url'], $img['medium_image']['url'], $img['large_image']['url'], $cid);
        }
    }

    /**
     * 画像情報の保存
     *
     * @param int $packageId
     * @param int $shopId
     * @param array $item
     */
    public static function saveImageData($packageId, $shopId, array $item)
    {
        DB::table('game_packages')
            ->where('id', $packageId)
            ->update([
                'shop_id'             => $shopId,
                'small_image_url'     => $item['small_image']['url'] ?? null,
                'small_image_width'   => $item['small_image']['width'] ?? null,
                'small_image_height'  => $item['small_image']['height'] ?? null,
                'medium_image_url'    => $item['medium_image']['url'] ?? null,
                'medium_image_width'  => $item['medium_image']['width'] ?? null,
                'medium_image_height' => $item['medium_image']['height'] ?? null,
                'large_image_url'     => $item['large_image']['url'] ?? null,
                'large_image_width'   => $item['large_image']['width'] ?? null,
                'large_image_height'  => $item['large_image']['height'] ?? null,
                'updated_at'          => DB::raw('CURRENT_TIMESTAMP')
            ]);
    }

    /**
     * ショップ情報の保存
     *
     * @param int $packageId
     * @param int $shopId
     * @param string $shopUrl
     * @param string $smallUrl
     * @param string $mediumUrl
     * @param string $largeUrl
     * @param $param1
     * @param null $param2
     * @param null $param3
     * @param null $param4
     * @param null $param5
     */
    public static function saveShop($packageId, $shopId, $shopUrl, $smallUrl, $mediumUrl, $largeUrl, $param1, $param2 = null, $param3 = null, $param4 = null, $param5 = null)
    {
        $sql =<<< SQL
INSERT INTO game_package_shops(
  package_id, shop_id, shop_url, small_image_url, medium_image_url, large_image_url
  , param1, param2, param3, param4, param5, updated_timestamp, created_at, updated_at
) VALUES (
  ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, UNIX_TIMESTAMP(), CURRENT_TIMESTAMP, CURRENT_TIMESTAMP 
)
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

        DB::insert($sql, [$packageId, $shopId, $shopUrl, $smallUrl, $mediumUrl, $largeUrl, $param1, $param2, $param3, $param4, $param5]);
    }

    /**
     * 新作ゲームを取得
     *
     * @return array
     */
    public static function getNewGame()
    {
        $appendQuery = ' AND is_adult = 0';
        if (Auth::check() && Auth::user()->adult == 1) {
            $appendQuery = '';
        }

        $sql =<<< SQL
SELECT
	shop.*,
	pkg.name
FROM (
	SELECT package_id, release_int, shop_url, small_image_url
	FROM game_package_shops
	WHERE shop_id = ? AND small_image_url IS NOT NULL {$appendQuery}
	ORDER BY release_int DESC
	LIMIT 20
) shop
	INNER JOIN game_packages pkg ON pkg.id = shop.package_id
SQL;

        return DB::select($sql, [Shop::AMAZON]);
    }
}