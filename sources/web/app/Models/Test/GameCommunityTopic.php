<?php
/**
 * ゲームコミュニティのトピックのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Illuminate\Support\Facades\DB;

class GameCommunityTopic
{
    /**
     * テストデータ生成
     */
    public static function create()
    {
        echo 'create game community topic test data.'.PHP_EOL;

        $gc = new \Hgs3\Models\Community\GameCommunity();

        $gcIds = Game::getIds();
        foreach ($gcIds as $gcId) {
            for ($i = 0; $i < 100; $i++) {
                $gc->writeTopic($gcId, 1, 'テスト' . $i, str_random(500));
            }
        }
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
}