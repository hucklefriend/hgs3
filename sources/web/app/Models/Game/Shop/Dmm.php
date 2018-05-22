<?php
/**
 * DMM
 */

namespace Hgs3\Models\Game\Shop;

class Dmm
{
    /**
     * 商品情報を取得
     *
     * @param string $cid
     * @param string $site
     * @return bool|mixed
     */
    public static function getItem($cid, $site)
    {
        $client = new \GuzzleHttp\Client();

        $url = 'https://api.dmm.com/affiliate/v3/ItemList?';
        $url .= http_build_query([
            'api_id'       => env('DMM_API_ID'),
            'affiliate_id' => env('DMM_ID'),
            'site'         => $site,
            'cid'          => $cid,
            'output'       => 'json'
        ]);

        $res = false;

        // 念のため、5回は繰り返す
        for ($i = 0; $i < 5; $i++) {
            try {
                $res = $client->get($url);
                break;
            } catch (\Exception $e) {
                sleep(1);
            }
        }

        if ($res !== false) {
            if ($res->getStatusCode() == 200) {
                return \json_decode($res->getBody());
            }
        }

        return false;
    }
}
