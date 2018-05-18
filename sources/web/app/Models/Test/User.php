<?php
/**
 * ユーザーのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\UserFollow;
use Illuminate\Support\Facades\File;

class User
{
    /**
     * ユーザーIDの配列を取得
     *
     * @return array
     */
    public static function getIds()
    {
        return DB::table('users')
            ->select('id')
            ->get()
            ->pluck('id');
    }


    /**
     * データを取得
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function get()
    {
        return \Hgs3\Models\User::all();
    }
}