<?php
/**
 * ユーザー行動タイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Hgs3\Log;
use Hgs3\Models\Orm;
use Hgs3\Models\User;

class UserActionTimeline extends TimelineAbstract
{
    /**
     * 参加
     *
     * @param User $user
     */
    public static function addSignUpText(User $user)
    {
        $text = '当サイトに参加しました！';

        self::insert($user->id, $text);
    }

    /**
     * フォローした
     *
     * @param User $user
     * @param User $followUser
     */
    public static function addFollowText(User $user, User $followUser)
    {
        $text = sprintf('<a href="%s">%sさん</a>をフォローしました。',
            route('プロフィール', ['showId' => $followUser->show_id]),
            e($followUser->name)
        );

        self::insert($user->id, $text);
    }

    /**
     * フォロー解除した
     *
     * @param User $user
     * @param User $followUser
     */
    public static function addFollowRemoveText(User $user, User $followUser)
    {
        $text = sprintf('<a href="%s">%sさん</a>のフォローを解除しました。',
            route('プロフィール', ['showId' => $followUser->show_id]),
            e($followUser->name)
        );

        self::insert($user->id, $text);
    }

    /**
     * サイト登録
     *
     * @param User $user
     * @param Orm\Site $site
     */
    public static function addSiteText(User $user, Orm\Site $site)
    {
        $text = sprintf('サイト「<a href="%s">%s</a>」を登録しました。',
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
    public static function addSiteUpdateText(User $user, Orm\Site $site)
    {
        $text = sprintf('サイト「<a href="%s">%s</a>」を更新しました。',
            route('サイト詳細', ['site' => $site->id]),
            e($site->name)
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
            self::getDB()->user_action_timeline->insertOne([
                'user_id' => $userId,
                'text'    => $text,
                'time'    => microtime(true)
            ]);
        } catch (\Exception $e) {
            Log::exceptionErrorNoThrow($e);
        }
    }

    /**
     * タイムラインを取得
     *
     * @param int $time
     * @param int $num
     * @return array
     */
    public static function get($time, $num)
    {
        $filter = [
            'time' => ['$lt' => $time]
        ];
        $options = [
            'sort'  => ['time' => -1],
            'limit' => $num,
        ];

        return self::getDB()->user_action_timeline->find($filter, $options)->toArray();
    }
}