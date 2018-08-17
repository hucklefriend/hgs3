<?php
/**
 * ネットワークレイアウト
 */

namespace Hgs3\Network;

use Hgs3\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class Network
{
    private $main;
    private $children = [];

    public function setMain(MainItem $mainItem)
    {
        $this->main = $mainItem;
    }

    public function addChild(SubItem $child)
    {
        $this->children[$child->id] = $child;
    }


}