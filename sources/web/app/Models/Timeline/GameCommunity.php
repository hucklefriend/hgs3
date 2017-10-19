<?php
/**
 * ゲームコミュニティタイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Illuminate\Support\Facades\Log;

class GameCommunity extends TimelineAbstract
{
    /**
     * 参加
     *
     * @param int $gameId
     * @param string $gameName
     * @param int $userId
     * @param string $userName
     */
    public static function addJoinUserText($gameId, $gameName, $userId, $userName)
    {
        self::setUserName($userId, $userName);
        self::setGameName($gameId, $gameName);

        $text = sprintf('参加中のコミュニティ「<a href="%s">%s</a>」に<a href="%s">%sさん</a>が参加しました',
            url2('community/g/' . $gameId),
            $gameName,
            url2('user/profile/' . $userId),
            $userName
        );

        self::insert($gameId, $text);
    }

    /**
     * 新規トピック
     *
     * @param int $gameId
     * @param string $gameName
     * @param int $topicId
     */
    public static function addNewTopicText($gameId, $gameName, $topicId)
    {
        self::setGameName($gameId, $gameName);

        $text = sprintf('参加中のコミュニティ「<a href="%s">%s</a>」に<a href="%s">新しいトピック</a>が作成されました',
            url2('community/g/' . $gameId),
            $gameName,
            url2('community/g/' . $gameId . 'topic/' . $topicId)
        );

        self::insert($gameId, $text);
    }

    /**
     * データ登録
     *
     * @param int $gameId
     * @param string $text
     * @return bool
     */
    private static function insert($gameId, $text)
    {
        try {
            self::getDB()->game_community_timeline->insertOne([
                'game_id' => $gameId,
                'text'    => $text,
                'time'    => microtime(true)
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return true;
    }
}