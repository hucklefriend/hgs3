<?php

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\UserFollow;

class User
{
    public static function create($num)
    {
        for ($i = 0; $i < $num; $i++) {
            $user = new \Hgs3\User([
                'name' => str_random(rand(3, 7)),
                'role' => 1,
                'adult' => rand(0, 1)
            ]);
            $user->save();
            unset($user);
        }
    }
}