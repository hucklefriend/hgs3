<?php
/**
 * マイページタイムラインモデル
 */

namespace Hgs3\Models\Timeline;


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

        $timeline += $this->getMySelfTimeline($userId, $time, $num + 1);

        if (empty($timeline)) {
            return [
                'timelines' => [],
                'hasNext'   => false
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
     * 自分に対してなにかしてくれたタイムライン
     *
     * @param int $userId
     * @param float $time
     * @param int $num
     * @return array
     */
    private function getMySelfTimeline($userId, $time, $num)
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