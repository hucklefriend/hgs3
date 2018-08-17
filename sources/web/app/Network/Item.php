<?php
/**
 * ネットワークアイテム
 */

namespace Hgs3\Network;

use Hgs3\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

abstract class Item
{
    public $id;
    public $dom;
    public $position;

    public function renderDOM($view, $data = [])
    {
        $this->dom = view($view, $data)->render();
    }

    public function setPosition()
    {

    }

    public function setPositionOffsetMain()
    {

    }
}