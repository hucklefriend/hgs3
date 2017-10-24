<?php
/**
 * ゲームソフトモデル
 */

namespace Hgs3\Models\Game;

use Hgs3\Constants\Game\Shop;
use Hgs3\Models\Game\Shop\Amazon;
use Illuminate\Support\Facades\DB;

class Package
{
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
            self::saveShop($packageId, Shop::AMAZON, '', $asin);
        } else {
            self::saveImageData($packageId, $item);
            self::saveShop($packageId, Shop::AMAZON, $item['shop_url'], $asin);
        }
    }

    /**
     * 画像情報の保存
     *
     * @param int $packageId
     * @param array $item
     */
    public static function saveImageData($packageId, array $item)
    {
        DB::table('game_packages')
            ->where('id', $packageId)
            ->update([
                'small_image_url'     => $item['small_image']['url'],
                'small_image_width'   => $item['small_image']['width'],
                'small_image_height'  => $item['small_image']['height'],
                'medium_image_url'    => $item['medium_image']['url'],
                'medium_image_width'  => $item['medium_image']['width'],
                'medium_image_height' => $item['medium_image']['height'],
                'large_image_url'     => $item['large_image']['url'],
                'large_image_width'   => $item['large_image']['width'],
                'large_image_height'  => $item['large_image']['height'],
                'updated_at'          => DB::raw('CURRENT_TIMESTAMP')
            ]);
    }

    /**
     * ショップ情報の保存
     *
     * @param int $packageId
     * @param int $shopId
     * @param string $shopUrl
     * @param string|null $param1
     */
    public static function saveShop($packageId, $shopId, $shopUrl, $param1)
    {
        $sql =<<< SQL
INSERT INTO game_package_shops(
  package_id, shop_id, shop_url, param1, created_at, updated_at
) VALUES (
  ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP 
)
ON DUPLICATE KEY UPDATE
  shop_url = VALUES(shop_url)
  , param1 = VALUES(param1)
  , updated_at = CURRENT_TIMESTAMP 
SQL;

        DB::insert($sql, [$packageId, $shopId, $shopUrl, $param1]);
    }
}