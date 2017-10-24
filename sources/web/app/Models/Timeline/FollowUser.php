<?php
/**
 * ユーザータイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Illuminate\Support\Facades\Log;
use Hgs3\Models\User;
use Hgs3\Models\Orm;

class FollowUser extends TimelineAbstract
{
    /**
     * サイト登録
     *
     * @param User $user
     * @param Orm\Site $site
     */
    public static function addAddSiteText(User $user, Orm\Site $site)
    {
        $text = sprintf('<a href="%s">%sさん</a>が新しいサイト「<a href="%s">%s</a>」を登録しました。',
            url2('user/profile/' . $user->id),
            $user->name,
            url2('site/detail/' . $site->id),
            $site->name
        );

        self::insert($user->id, $text);
    }

    /**
     * サイト更新
     *
     * @param User $user
     * @param Orm\Site $site
     */
    public static function addUpdateSiteText(User $user, Orm\Site $site)
    {
        $text = sprintf('<a href="%s">%sさん</a>がサイト「<a href="%s">%s</a>」の情報を更新しました。',
            url2('user/profile/' . $user->id),
            $user->name,
            url2('site/detail/' . $site->id),
            $site->name
        );

        self::insert($user->id, $text);
    }

    /**
     * ゲームコミュニティ参加
     *
     * @param User $user
     * @param Orm\GameSoft $soft
     */
    public static function addJoinGameCommunityText(User $user, Orm\GameSoft $soft)
    {
        $text = sprintf('<a href="%s">%sさん</a>がコミュニティ「<a href="%s">%s</a>」に参加しました。',
            url2('user/profile/' . $user->id),
            $user->name,
            url2('community/g/' . $soft->id),
            $soft->name
        );

        self::insert($user->id, $text);
    }

    /**
     * ユーザーコミュニティ参加
     *
     * @param User $user
     * @param Orm\UserCommunity $userCommunity
     */
    public static function addJoinUserCommunityText(User $user, Orm\UserCommunity $userCommunity)
    {
        $text = sprintf('<a href="%s">%sさん</a>がコミュニティ「<a href="%s">%s</a>」に参加しました。',
            url2('user/profile/' . $user->id),
            $user->name,
            url2('community/u/' . $userCommunity->id),
            $userCommunity->name
        );

        self::insert($user->id, $text);
    }

    /**
     * ゲームコミュニティ脱退
     *
     * @param User $user
     * @param Orm\GameSoft $soft
     */
    public static function addLeaveGameCommunityText(User $user, Orm\GameSoft $soft)
    {
        $text = sprintf('<a href="%s">%sさん</a>がコミュニティ「<a href="%s">%s</a>」を脱退しました。',
            url2('user/profile/' . $user->id),
            $user->name,
            url2('community/g/' . $soft->id),
            $soft->name
        );

        self::insert($user->id, $text);
    }

    /**
     * ユーザーコミュニティ脱退
     *
     * @param User $user
     * @param Orm\UserCommunity $userCommunity
     */
    public static function addLeaveUserCommunityText(User $user, Orm\UserCommunity $userCommunity)
    {
        $text = sprintf('<a href="%s">%sさん</a>がコミュニティ「<a href="%s">%s</a>」を脱退しました。',
            url2('user/profile/' . $user->id),
            $user->name,
            url2('community/u/' . $userCommunity->id),
            $userCommunity->name
        );

        self::insert($user->id, $text);
    }

    /**
     * レビュー投稿
     *
     * @param User $user
     * @param Orm\GameSoft $soft
     * @param Orm\Review $review
     */
    public static function addWriteReviewText(User $user, Orm\GameSoft $soft, Orm\Review $review)
    {
        $text = sprintf('<a href="%s">%sさん</a>が<a href="%s">%sのレビュー</a>%sを投稿しました。',
            url2('user/profile/' . $user->id),
            $user->name,
            url2('review/detail/' . $review->id),
            $soft->name,
            $review->is_spoiler ? '(ネタバレあり)' : ''
        );

        self::insert($user->id, $text);
    }

    /**
     * お気に入りゲーム登録
     *
     * @param User $user
     * @param Orm\GameSoft $soft
     */
    public static function addAddFavoriteSoftText(User $user, Orm\GameSoft $soft)
    {
        $text = sprintf('<a href="%s">%sさん</a>が<a href="%s">%s</a>をお気に入りゲームに登録しました。',
            url2('user/profile/' . $user->id),
            $user->name,
            url2('game/soft/' . $soft->id),
            $soft->name
        );

        self::insert($user->id, $text);
    }

    /**
     * データ登録
     *
     * @param int $userId
     * @param string $text
     * @return bool
     */
    private static function insert($userId, $text)
    {
        try {
            self::getDB()->follow_user_timeline->insertOne([
                'user_id' => $userId,
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