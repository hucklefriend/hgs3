<?php

namespace Hgs3\Constants;


use Illuminate\Support\Facades\Auth;

class UserRole
{
    const GUEST = 1;
    const USER = 10;
    const ADMIN = 100;

    public static function isUser()
    {
        $user = Auth::user();
        if ($user != null) {
            return $user->role >= self::USER;
        }

        return false;
    }

    public static function isAdmin()
    {
        $user = Auth::user();
        if ($user != null) {
            return $user->role >= self::ADMIN;
        }

        return false;
    }
}