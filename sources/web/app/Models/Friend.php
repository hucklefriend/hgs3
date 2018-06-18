<?php

namespace Hgs3\Models;

use Hgs3\Constants\SocialSite;
use Hgs3\Constants\UserRole;
use Hgs3\Models\Account\SignUp;
use Hgs3\Models\Timeline\ToMe;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Friend
{
    public static function getList()
    {
        return DB::table('users')
            ->orderBy('last_login_at', 'DESC')
            ->paginate(20);
    }
}
