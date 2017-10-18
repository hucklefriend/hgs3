<?php

namespace Hgs3\Constants;


use Illuminate\Support\Facades\Auth;

class UserRole
{
    const USER = 0;
    const EDITOR = 50;
    const ADMIN = 100;

    /**
     * データ編集権限があるか
     *
     * @return bool
     */
    public static function isDataEditor()
    {
        $user = Auth::user();
        if ($user != null) {
            return $user->role >= self::EDITOR;
        }

        return false;
    }

    /**
     * 管理権限を持っているかどうか
     *
     * @return bool
     */
    public static function isAdmin()
    {
        $user = Auth::user();
        if ($user != null) {
            return $user->role >= self::ADMIN;
        }

        return false;
    }
}