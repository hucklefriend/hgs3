<?php
/**
 * ユーザーのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\UserFollow;

class Site
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create site test data.'.PHP_EOL;

        $site = new \Hgs3\Models\Site();

        $userIds = User::getIds();
        $maxUser = count($userIds) - 1;

        $gameIds = game::getIds();
        $maxGame = count($gameIds) - 1;

        for ($i = 0; $i < $maxUser; $i++) {
            $n = rand(0, 3);
            for ($j = 0; $j < $n; $j++) {
                $orm = new \Hgs3\Models\Orm\Site();

                $orm->user_id = $userIds[$i];
                $orm->name = str_random(rand(3, 30));
                $orm->url = 'http://fake.' . str_random(rand(3, 10)) . '.com/';
                $orm->banner_url = '';
                $orm->presentation = str_random(rand(50, 500));
                $orm->rate = rand(1, 3);
                $orm->main_contents_id = rand(1, 7);
                $orm->gender = rand(1, 3);
                $orm->open_type = 0;
                $orm->in_count = rand(0, 999999);
                $orm->out_count = rand(0, 999999);
                $orm->good_count = 0;
                $orm->bad_count = 0;
                $orm->registered_timestamp = time();
                $orm->updated_timestamp = time();

                $handleGameNum = rand(1, 10);
                $handleGame = '';
                for ($k = 0; $k < $handleGameNum; $k++) {
                    $handleGame .= $gameIds[rand(0, $maxGame)] . ',';
                }

                $site->add($orm->user_id, $orm, $handleGame);
            }
        }
    }

    /**
     * ゲームIDの配列を取得
     *
     * @return array
     */
    public static function getIds()
    {
        return DB::table('sites')
            ->select('id')
            ->get()
            ->pluck('id');
    }
}