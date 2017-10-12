<?php
/**
 * レビュー
 */

namespace Hgs3\Models\Test;
use Hgs3\Models\Orm\ReviewTotal;
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

        $users = User::getIds();
        $pkgs = Package::get();

        $userMax = count($users) - 1;
        $pkgMax = count($pkgs) - 1;

        for ($i = 0; $i < $num; $i++) {
            $pkg = $pkgs[rand(0, $pkgMax)];

            $orm = new \Hgs3\Models\Orm\Review([
                'user_id'         => $users[rand(0, $userMax)],
                'game_id'         => $pkg->game_id,
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
            $orm->save();
            unset($orm);
        }

        $games = Game::getIds();
        foreach ($games as $gameId) {
            ReviewTotal::calculate($gameId);
        }
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
}