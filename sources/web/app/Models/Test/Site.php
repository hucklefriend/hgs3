<?php
/**
 * ユーザーのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm;

class Site
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create site test data.'.PHP_EOL;

        DB::table('sites')->truncate();
        DB::table('site_new_arrivals')->truncate();
        DB::table('site_search_indices')->truncate();
        DB::table('site_handle_softs')->truncate();

        $users = User::get();
        $maxUser = $users->count() - 1;

        $softIds = GameSoft::getIds();
        $maxSoft = count($softIds) - 1;

        $rates = [0, 15, 18];

        for ($i = 0; $i < $maxUser; $i++) {
            $u = $users[$i];
            $n = rand(0, 3);

            $orm = new Orm\Site();
            for ($j = 0; $j < $n; $j++) {
                unset($orm->id);
                $orm->user_id = $u->id;
                $orm->name = str_random(rand(3, 30));
                $orm->url = 'http://fake.' . str_random(rand(3, 10)) . '.com/';
                $orm->presentation = str_random(rand(50, 500));
                $orm->rate = $rates[rand(0, 2)];
                $orm->main_contents_id = rand(1, 7);
                $orm->gender = rand(1, 3);
                $orm->open_type = 0;
                $orm->in_count = rand(0, 9999);
                $orm->out_count = rand(0, 9999);
                $orm->good_num = 0;
                $orm->bad_num = 0;
                $orm->registered_timestamp = time();
                $orm->updated_timestamp = time();

                $handleSoftNum = rand(5, 20);
                $handleSoft = '';
                for ($k = 0; $k < $handleSoftNum; $k++) {
                    $handleSoft .= $softIds[rand(0, $maxSoft)] . ',';
                }

                rtrim($handleSoft, ',');

                \Hgs3\Models\Site::save($u, $orm, $handleSoft, null, null);
            }
        }
    }

    /**
     * サイトIDの配列を取得
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


    /**
     * サイトORMの配列を取得
     *
     * @return array
     */
    public static function get()
    {
        return Orm\Site::all();
    }
}