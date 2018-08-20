<?php
/**
 * ネットワークアイテム
 */

namespace Hgs3\Network;

use Hgs3\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class Item
{
    public $id;
    public $parentId;
    public $position;
    public $view;
    public $viewData = [];

    public function setPositionParentOffset( $offsetX = 0, $offsetY = 0)
    {
        $this->position = [
            'type'   => 'parent',
            'offset' => [
                'x' => $offsetX,
                'y' => $offsetY
            ]
        ];
    }

    public function setPositionFixed($x = 0, $y = 0)
    {
        $this->position = [
            'type'     => 'fixed',
            'position' => [
                'x' => $x,
                'y' => $y
            ]
        ];
    }


    public function toArray()
    {
        return [
            'id'       => $this->id,
            'parentId' => $this->parentId,
            'position' => $this->position,
            'dom'      => view('network/' . $this->view, $this->viewData)->render(),
        ];
    }

    public function set($data)
    {
        $this->id = $data->id;
        $this->parentId = $data->parentId ?? null;
        $this->position = $data->position;
        $this->view = $data->view;
        $this->viewData = $data->viewData ?? [];
    }
}