<?php
/**
 * ユーザーのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\UserFollow;

class User
{
    /**
     * テストデータ生成
     *
     * @param $num
     */
    public static function create($num)
    {
        echo 'create user test data.'.PHP_EOL;

        for ($i = 0; $i < $num; $i++) {
            $user = new \Hgs3\Models\User([
                'name' => str_random(rand(3, 7)),
                'role' => 1,
                'adult' => rand(0, 1)
            ]);
            $user->save();
            unset($user);
        }
    }

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