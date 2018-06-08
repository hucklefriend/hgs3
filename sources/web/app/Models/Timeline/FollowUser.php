<?php
/**
 * ユーザータイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Hgs3\Log;
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
            route('プロフィール', ['showId' => $user->show_id]),
            e($user->name),
            route('サイト詳細', ['site' => $site->id]),
            e($site->name)
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
            route('プロフィール', ['showId' => $user->show_id]),
            e($user->name),
            route('サイト詳細', ['site' => $site->id]),
            e($site->name)
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
            route('プロフィール', ['showId' => $user->show_id]),
            e($user->name),
            route('レビュー', ['review' => $review->id]),
            e($soft->name),
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
            route('プロフィール', ['showId' => $user->show_id]),
            e($user->name),
            route('ゲーム詳細', ['ゲーム詳細' => $soft->id]),
            e($soft->name)
        );

        self::insert($user->id, $text);
    }

    /**
     * データ登録
     *
     * @param int $userId
     * @param string $text
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
            Log::exceptionErrorNoThrow($e);
        }
    }
}