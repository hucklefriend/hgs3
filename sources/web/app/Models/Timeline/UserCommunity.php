<?php
/**
 * ユーザーコミュニティタイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Illuminate\Support\Facades\Log;
use Hgs3\Models\User;
use Hgs3\Models\Orm;

class UserCommunity extends TimelineAbstract
{
    /**
     * 参加
     *
     * @param Orm\UserCommunity $userCommunity
     * @param User $user
     */
    public static function addJoinUserText(Orm\UserCommunity $userCommunity, User $user)
    {
        $text = sprintf('参加中のコミュニティ「<a href="%s">%s</a>」に<a href="%s">%sさん</a>が参加しました',
            route('ユーザーコミュニティ', ['uc' => $userCommunity->id]),
            $userCommunity->name,
            route('プロフィール', ['showId' => $user->show_id]),
            $user->name
        );

        self::insert($userCommunity->id, $text);
    }

    /**
     * 新規トピック作成
     *
     * @param Orm\UserCommunity $userCommunity
     * @param Orm\UserCommunityTopic $topic
     */
    public static function addNewTopicText(Orm\UserCommunity $userCommunity, Orm\UserCommunityTopic $topic)
    {
        $text = sprintf('参加中のコミュニティ「<a href="%s">%s</a>」に<a href="%s">新しいトピック</a>が作成されました',
            route('ユーザーコミュニティ', ['uc' => $userCommunity->id]),
            $userCommunity->name,
            route('ユーザーコミュニティ投稿詳細', ['uc' => $userCommunity->id, 'uct' => $topic->id])
        );

        self::insert($userCommunity->id, $text);
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