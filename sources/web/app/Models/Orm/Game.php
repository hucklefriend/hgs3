<?php

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public static function getNameHash(array $ids = array())
    {
        $tbl = DB::table('games');

        if (!empty($ids)) {
            $tbl->whereIn('id', $ids);
        }

        return $tbl->get()->pluck('name', 'id')->toArray();
    }
}
