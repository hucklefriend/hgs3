<?php
/**
 * レビュー
 */

namespace Hgs3\Models\Test;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;

class Review
{
    /**
     * テストデータ生成
     *
     * @param $num
     */
    public static function create($num)
    {
        echo 'create review test data.'.PHP_EOL;

        $users = User::get();
        $packages = Package::get();

        $userMax = count($users) - 1;
        $packageMax = count($packages) - 1;

        $r = new \Hgs3\Models\Review();


        for ($i = 0; $i < $num; $i++) {
            $pkg = $packages[rand(0, $packageMax)];
            $user = $users[rand(0, $userMax)];

            $orm = new Orm\ReviewDraft([
                'user_id'         => $user->id,
                'game_id'         => $pkg->soft_id,
                'package_id'      => $pkg->id,
                'fear'            => rand(0, 5),
                'story'           => rand(0, 5),
                'volume'          => rand(0, 5),
                'difficulty'      => rand(0, 5),
                'graphic'         => rand(0, 5),
                'sound'           => rand(0, 5),
                'crowded'         => rand(0, 5),
                'controllability' => rand(0, 5),
                'recommend'       => rand(0, 5),
                'is_spoiler'      => rand(0, 1),
                'progress'        => str_random(rand(50, 300)),
                'text'            => str_random(rand(50, 3000)),
                'title'           => str_random(rand(5, 100)),
                'post_date'       => new \DateTime()
            ]);

            $r->save(user, $orm);
            unset($orm);
        }

        unset($users);
        unset($pkgs);

        $games = GameSoft::getIds();
        foreach ($games as $gameId) {
            Orm\ReviewTotal::calculate($gameId);
        }

        unset($games);
    }

    /**
     * レビューIDの配列を取得
     *
     * @return array
     */
    public static function getIds()
    {
        return DB::table('reviews')
            ->select('id')
            ->get()
            ->pluck('id');
    }

    /**
     * レビューの配列を取得
     *
     * @return array
     */
    public static function get()
    {
        return Orm\Review::all();
    }
}