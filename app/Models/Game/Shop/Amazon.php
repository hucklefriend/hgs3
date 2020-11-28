<?php
/**
 * Amazonモデル
 */

namespace Hgs3\Models\Game\Shop;

use ApaiIO\Configuration\GenericConfiguration;


class Amazon
{
    /**
     * ASINからデータを取得
     *
     * @param string $asin
     * @return array
     */
    public static function getData($asin)
    {
        $conf = new GenericConfiguration();
        $client = new \GuzzleHttp\Client();
        $request = new \ApaiIO\Request\GuzzleRequest($client);

        $conf->setCountry(env('AMAZON_COUNTRY'))
            ->setAccessKey(env('AMAZON_API_ACCESS_KEY'))
            ->setSecretKey(env('AMAZON_API_SECRET_KEY'))
            ->setAssociateTag(env('AMAZON_ASSOCIATE_TAG'))
            ->setRequest($request);

        $apaiIO = new \ApaiIO\ApaiIO($conf);

        $lookup = new \ApaiIO\Operations\Lookup();
        $lookup->setItemId($asin);
        $lookup->setResponseGroup(['Medium']);

        $item = null;
        for ($i = 0 ; $i < 5; $i++) {
            try {
                $res = $apaiIO->runOperation($lookup);
                $results = simplexml_load_string($res);
                if ($results->Items->Request->IsValid) {
                    $item = $results->Items->Item[0];
                }
                break;
            } catch (\Exception $e) {
                sleep(3);
            }
        }

        if ($item === null) {
            return [];
        } else {
            $data = [
                'shop_url' => (string)$item->DetailPageURL
            ];

            if (isset($item->SmallImage)) {
                $data['small_image'] = [
                    'url' => (string)$item->SmallImage->URL,
                    'height' => (int)$item->SmallImage->Height,
                    'width' => (int)$item->SmallImage->Width
                ];
            }

            if (isset($item->MediumImage)) {
                $data['medium_image'] = [
                    'url' => (string)$item->MediumImage->URL,
                    'height' => (int)$item->MediumImage->Height,
                    'width' => (int)$item->MediumImage->Width
                ];
            }

            if (isset($item->LargeImage)) {
                $data['large_image'] = [
                    'url' => (string)$item->LargeImage->URL,
                    'height' => (int)$item->LargeImage->Height,
                    'width' => (int)$item->LargeImage->Width
                ];
            }

            return $data;
        }
    }
}