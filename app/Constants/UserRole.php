<?php

namespace Hgs3\Constants;


use Illuminate\Support\Facades\Auth;

class UserRole
{
    const USER = 10;
    const EDITOR = 50;
    const ADMIN = 100;

    /**
     * データ編集権限があるか
     *
     * @return bool
     */
    public static function isDataEditor()
    {
        static $isDataEditor = null;

        if ($isDataEditor === null) {
            $user = Auth::user();
            if ($user != null) {
                $isDataEditor = $user->role >= self::EDITOR;
            }
        }

        return $isDataEditor;
    }

    /**
     * 管理権限を持っているかどうか
     *
     * @return bool
     */
    public static function isAdmin()
    {
        static $isAdmin = null;

        if ($isAdmin === null) {
            $user = Auth::user();
            if ($user != null) {
                $isAdmin = $user->role >= self::ADMIN;
            }
        }

        return $isAdmin;
    }
}