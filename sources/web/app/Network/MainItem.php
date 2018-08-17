<?php
/**
 * ネットワークアイテム
 */

namespace Hgs3\Network;

use Hgs3\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class MainItem extends Item
{
    public $main;
    public $children = [];

    public function setMain()
    {

    }


    public function object()
    {
        $obj = new \stdClass();

    }
}