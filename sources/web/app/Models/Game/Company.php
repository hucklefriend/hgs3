<?php

namespace Hgs3\Models\Game;

use Hgs3\Models\Orm\GameSoft;
use Hgs3\Models\Orm\GameCompany;
use Illuminate\Support\Facades\DB;

class Company
{
    public function getList()
    {
        return DB::table('game_companies')
            ->select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getDetail(GameCompany $gameCompany)
    {
        $data = array();

        $data['soft'] = GameSoft::where('company_id', $gameCompany->id)
            ->orderBy('phonetic_order')
            ->get();

        return $data;
    }

    public static function getSelectItems($withEmpty)
    {

    }
}