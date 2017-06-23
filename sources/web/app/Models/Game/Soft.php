<?php

namespace Hgs3\Models\Game;
use Illuminate\Support\Facades\DB;

class Soft
{
    public function get_list()
    {
        $soft = \Hgs3\Models\Orm\Game::all();
        return $soft;
    }
}