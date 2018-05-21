<?php

namespace Hgs3\Models;

class Dmm
{
    public static function getItem($cid)
    {
        $client = new \GuzzleHttp\Client();

        $url = 'https://api.dmm.com/affiliate/v3/ItemList?';
        $url .= http_build_query([
            'api_id' => env('DMM_API_ID'),
            'affiliate_id' => env('DMM_ID'),
            'site' => 'DMM.R18',
            'cid' => $cid,
            'output' => 'json'
        ]);

        $res = false;

        // 念のため、5回は繰り返す
        for ($i = 0; $i < 5; $i++) {
            try {
                $res = $client->get($url);
                break;
            } catch (\Exception $e) {
                $res = false;
                sleep(1);
            }
        }

        if ($res !== false) {
            if ($res->getStatusCode() == 200) {
                return json_decode($res->getBody());
            }
        }

        return $res;
    }
}
