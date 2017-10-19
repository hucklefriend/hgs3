<?php
/**
 * ユーザーコミュニティタイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Illuminate\Support\Facades\Log;

class UserCommunity extends TimelineAbstract
{
    /**
     * 参加
     *
     * @param int $userCommunityId
     * @param string $userCommunityName
     * @param int $userId
     * @param string $userName
     */
    public static function addJoinUserText($userCommunityId, $userCommunityName, $userId, $userName)
    {
        self::setUserName($userId, $userName);
        self::setCommunityName($userCommunityId, $userCommunityName);

        $text = sprintf('参加中のコミュニティ「<a href="%s">%s</a>」に<a href="%s">%sさん</a>が参加しました',
            url2('community/u/' . $userCommunityId),
            $userCommunityName,
            url2('user/profile/' . $userId),
            $userName
        );

        self::insert($userCommunityId, $text);
    }

    /**
     * 新規トピック
     *
     * @param int $userCommunityId
     * @param string $userCommunityName
     * @param int $topicId
     */
    public static function addNewTopicText($userCommunityId, $userCommunityName, $topicId)
    {
        self::setCommunityName($userCommunityId, $userCommunityName);

        $text = sprintf('参加中のコミュニティ「<a href="%s">%s</a>」に<a href="%s">新しいトピック</a>が作成されました',
            url2('community/u/' . $userCommunityId),
            $userCommunityName,
            url2('community/u/' . $userCommunityId . 'topic/' . $topicId)
        );

        self::insert($userCommunityId, $text);
    }

    /**
     * データ登録
     *
     * @param int $userCommunityId
     * @param string $text
     * @return bool
     */
    private static function insert($userCommunityId, $text)
    {
        try {
            self::getDB()->user_community_timeline->insertOne([
                'user_community_id' => $userCommunityId,
                'text'              => $text,
                'time'              => microtime(true)
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return true;
    }
}