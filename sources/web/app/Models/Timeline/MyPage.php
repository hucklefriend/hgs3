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
    public static function getTimeline($userId, $time, $num)
    {
        // 各タイムラインのデータを必要数+1取得
        // +1取るのは、次があるかのチェックのため
        $favoriteSoft = self::getFavoriteSoftTimeline($userId, $time, $num + 1);
        //$favoriteSite = self::getFavoriteSiteTimeline($userId, $time, $num + 1);
        $toMe = self::getToMeTimeline($userId, $time, $num + 1);
        $followUser = self::getFollowUserTimeline($userId, $time, $num + 1);
        $gameCommunity = self::getGameCommunityTimeline($userId, $time, $num + 1);
        $userCommunity = self::getUserCommunityTimeline($userId, $time, $num + 1);

        // 混ぜる
        $timeline = array_merge($favoriteSoft, $toMe, $followUser, $gameCommunity, $userCommunity);

        unset($favoriteGame);
        unset($toMe);
        unset($followUser);
        unset($gameCommunity);
        unset($userCommunity);

        if (empty($timeline)) {
            return [
                'timelines' => [],
                'hasNext'   => false,
                'moreTime'  => 0
            ];
        }

        // 時間順にソート
        $sort = [];
        foreach ($timeline as $key => $t) {
            $sort[$key] = $t['time'] * 1000;
        }
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
     * フォローユーザータイムライン
     *
     * @param int $userId
     * @param float $time
     * @param int $num
     * @return array
     */
    private static function getFollowUserTimeline($userId, $time, $num)
    {
        $followUserIds = Orm\UserFollow::select(['follow_user_id'])
            ->where('user_id', $userId)
            ->get()
            ->pluck('follow_user_id')
            ->toArray();

        $filter = [
            'user_id' => ['$in' => $followUserIds],
            'time' => ['$lt' => $time]
        ];
        $options = [
            'sort'  => ['time' => -1],
            'limit' => $num,
        ];

        $db = self::getDB();
        return $db->follow_user_timeline->find($filter, $options)->toArray();
    }

    /**
     * お気に入りゲームタイムライン
     *
     * @param int $userId
     * @param float $time
     * @param int $num
     * @return array
     */
    private static function getFavoriteSoftTimeline($userId, $time, $num)
    {
        $softIds = Orm\UserFavoriteSoft::select(['soft_id'])
            ->where('user_id', $userId)
            ->get()
            ->pluck('soft_id')
            ->toArray();

        $filter = [
            'soft_id' => ['$in' => $softIds],
            'time'    => ['$lt' => $time]
        ];
        $options = [
            'sort'  => ['time' => -1],
            'limit' => $num,
        ];

        $db = self::getDB();
        return $db->favorite_soft_timeline->find($filter, $options)->toArray();
    }

    /**
     * 自分に対してなにかしてくれたタイムライン
     *
     * @param int $userId
     * @param float $time
     * @param int $num
     * @return array
     */
    private static function getToMeTimeline($userId, $time, $num)
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

    /**
     * ユーザーコミュニティタイムライン
     *
     * @param int $userId
     * @param float $time
     * @param int $num
     * @return array
     */
    private static function getUserCommunityTimeline($userId, $time, $num)
    {
        $userCommunityIds = Orm\UserCommunityMember::select(['user_community_id'])
            ->where('user_id', $userId)
            ->get()
            ->pluck('user_community_id')
            ->toArray();

        $filter = [
            'user_community_id' => ['$in' => $userCommunityIds],
            'time' => ['$lt' => $time]
        ];
        $options = [
            'sort'  => ['time' => -1],
            'limit' => $num,
        ];

        $db = self::getDB();
        return $db->user_community_timeline->find($filter, $options)->toArray();
    }

    /**
     * ゲームコミュニティタイムライン
     *
     * @param int $userId
     * @param float $time
     * @param int $num
     * @return array
     */
    private static function getGameCommunityTimeline($userId, $time, $num)
    {
        $softIds = Orm\GameCommunityMember::select(['soft_id'])
            ->where('user_id', $userId)
            ->get()
            ->pluck('soft_id')
            ->toArray();

        $filter = [
            'soft_id' => ['$in' => $softIds],
            'time'    => ['$lt' => $time]
        ];
        $options = [
            'sort'  => ['time' => -1],
            'limit' => $num,
        ];

        $db = self::getDB();
        return $db->game_community_timeline->find($filter, $options)->toArray();
    }
}