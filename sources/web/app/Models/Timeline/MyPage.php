<?php
/**
 * マイページタイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Hgs3\Models\Orm;

class MyPage extends TimelineAbstract
{
    /**
     * タイムライン取得
     *
     * @param int $userId
     * @param float $time
     * @param int $num
     * return array
     */
    public function getTimeline($userId, $time, $num)
    {
        $timeline = [];

        $timeline += $this->getFavoriteGameTimeline($userId, $time, $num + 1);
        //$timeline += $this->getToMeTimeline($userId, $time, $num + 1);

        if (empty($timeline)) {
            return [
                'timelines' => [],
                'hasNext'   => false,
                'moreTime'  => 0
            ];
        }

        // 時間順にソート
        $sort = array_pluck($timeline, 'time');
        array_multisort($sort, SORT_DESC, $timeline);

        if (count($timeline) <= $num) {
            return [
                'timelines' => $timeline,
                'hasNext'   => false,
                'moreTime'  => 0
            ];
        } else {
            return [
                'timelines' => array_slice($timeline, 0, $num),
                'hasNext'   => true,
                'moreTime'  => $timeline[$num - 1]['time']
            ];
        }
    }


    /**
     * お気に入りゲームタイムライン
     *
     * @param int $userId
     * @param float $time
     * @param int $num
     * @return array
     */
    private function getFavoriteGameTimeline($userId, $time, $num)
    {
        $gameIds = Orm\UserFavoriteGame::select(['game_id'])
            ->where('user_id', $userId)
            ->get()
            ->pluck('game_id')
            ->toArray();

        $filter = [
            'game_id' => ['$in' => $gameIds],
            'time' => ['$lt' => $time]
        ];
        $options = [
            'sort'  => ['time' => -1],
            'limit' => $num,
        ];

        $db = self::getDB();
        return $db->favorite_game_timeline->find($filter, $options)->toArray();
    }



    /**
     * 自分に対してなにかしてくれたタイムライン
     *
     * @param int $userId
     * @param float $time
     * @param int $num
     * @return array
     */
    private function getToMeTimeline($userId, $time, $num)
    {
        $filter = [
            'user_id' => $userId,
            'time' => ['$lt' => $time]
        ];
        $options = [
            'sort'  => ['time' => -1],
            'limit' => $num,
        ];

        $db = self::getDB();
        return $db->to_me_timeline->find($filter, $options)->toArray();
    }
}