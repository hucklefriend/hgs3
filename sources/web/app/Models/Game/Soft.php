<?php

namespace App\Models\Game;
use Illuminate\Support\Facades\DB;

class Soft
{
    public function get_list()
    {
        $soft = \App\Models\Orm\Game::all();
        return $soft;
    }
}