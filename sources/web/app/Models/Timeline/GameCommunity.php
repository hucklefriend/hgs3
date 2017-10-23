<?php
/**
 * ゲームコミュニティタイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Illuminate\Support\Facades\Log;
use Hgs3\Models\Orm;
use Hgs3\Models\User;

class GameCommunity extends TimelineAbstract
{
    /**
     * 新しい参加者
     *
     * @param Orm\GameSoft $soft
     * @param User $user
     */
    public static function addJoinUserText(Orm\GameSoft $soft, User $user)
    {
        $text = sprintf('参加中のコミュニティ「<a href="%s">%s</a>」に<a href="%s">%sさん</a>が参加しました',
            url2('community/g/' . $soft->id),
            $soft->name,
            url2('user/profile/' . $user->id),
            $user->name
        );

        self::insert($soft->id, $text);
    }

    /**
     * 新規トピック
     *
     * @param Orm\GameSoft $soft
     * @param Orm\GameCommunityTopic $topic
     */
    public static function addNewTopicText(Orm\GameSoft $soft, Orm\GameCommunityTopic $topic)
    {
        $text = sprintf('参加中のコミュニティ「<a href="%s">%s</a>」に<a href="%s">新しいトピック</a>が作成されました',
            url2('community/g/' . $soft->id),
            $soft->name,
            url2('community/g/' . $soft->id . 'topic/' . $topic->id)
        );

        self::insert($soft->id, $text);
    }

    /**
     * データ登録
     *
     * @param int $softId
     * @param string $text
     * @return bool
     */
    private static function insert($softId, $text)
    {
        try {
            self::getDB()->game_community_timeline->insertOne([
                'soft_id' => $softId,
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