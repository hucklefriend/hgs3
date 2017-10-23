<?php
/**
 * Amazonモデル
 */

namespace Hgs3\Models\Game\Shop;

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Request\GuzzleRequest;

class Amazon
{
    public static function getData($asin)
    {
        $conf = new GenericConfiguration();
        $client = new GuzzleHttpClient();
        $request = new GuzzleRequest();





    }
}