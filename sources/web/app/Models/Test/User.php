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
            \Hgs3\Models\User::register([
                'name'  => self::getSampleName()
            ]);
        }
    }

    /**
     * サンプルの名前を取得
     *
     * @return string
     */
    private static function getSampleName()
    {
        $names = [
            '香華園',
            '桜雪',
            'いずみ沙羅',
            'よるとり',
            '南町奉行屯所',
            'KINCZEM',
            'ＧＯＭＢＥ',
            '豪腕はりー',
            '松永朝美',
            'いちゃいちゃNavi WebMaster',
            'yowamax',
            '霜月茶柚',
            '澪つくし',
            'ＪＩＭ．Ｋ',
            'MILK COCOA',
            'RedChedar',
            'アメット',
            'プシュケリア',
            '和泉凛香',
        ];

        $i = rand(0, count($names) - 1);
        return $names[$i];
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