<?php

namespace Hgs3\Models\User;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\UserFollow;

class FavoriteGame
{
    public function add($gameId, $userId)
    {
        $sql =<<< SQL
INSERT IGNORE INTO user_favorite_games
()
SQL;



    }
}