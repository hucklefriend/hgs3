<?php
/**
 * ゲームコミュニティのトピックのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm;

class GameCommunityTopic
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create game community topic test data.'.PHP_EOL;

        $gc = new \Hgs3\Models\Community\GameCommunity();

        $users = User::get();
        $userMax = $users->count() - 1;
        $gameSofts = GameSoft::get();

        foreach ($gameSofts as $gameSoft) {
            if (rand(0, 100) > 30) {
                continue;
            }

            $n = rand(0, 10);
            for ($i = 0; $i < $n; $i++) {
                $gc->writeTopic($gameSoft, $users[rand(0, $userMax)], 'テスト' . $i, str_random(500));
            }
        }

        unset($users);
        unset($gameSofts);
    }

    /**
     * ユーザーIDの配列を取得
     *
     * @return array
     */
    public static function getIds()
    {
        return DB::table('game_community_topics')
            ->select('id')
            ->get()
            ->pluck('id');
    }

    /**
     * ORMのコレクションを取得
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function get()
    {
        return Orm\GameCommunityTopic::all();
    }
}