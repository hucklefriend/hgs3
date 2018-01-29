<?php
/**
 * 自分のタイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Illuminate\Support\Facades\Log;
use Hgs3\Models\User;
use Hgs3\Models\Orm;

class ToMe extends TimelineAbstract
{
    /**
     * 誰かにフォローされた
     *
     * @param User $user
     * @param User $follower
     */
    public static function addFollowerText(User $user, User $follower)
    {
        $text = sprintf('<a href="%s">%sさん</a>にフォローされました',
            route('プロフィール', ['showId' => $follower->show_id]),
            $follower->name
        );

        self::insert($user->id, $text);
    }

    /**
     * サイトにいいねされた
     *
     * @param User $user
     * @param User $goodUser
     * @param Orm\Site $site
     */
    public static function addSiteGoodText(User $user, User $goodUser, Orm\Site $site)
    {
        if ($goodUser === null) {
            $text = sprintf('サイト「<a href="%s">%s</a>」がいいねされました。',
                route('サイト詳細', ['site' => $site->id]),
                $site->name
            );
        } else {
            $text = sprintf('<a href="%s">%sさん</a>がサイト「<a href="%s">%s</a>」にいいねしてくれました。',
                route('プロフィール', ['showId' => $goodUser->show_id]),
                $goodUser->name,
                route('サイト詳細', ['site' => $site->id]),
                $site->name
            );
        }

        self::insert($user->id, $text);
    }

    /**
     * サイトへのいいね数がn件を超えた
     *
     * @param User $user
     * @param Orm\Site $site
     * @param $prevMaxGoodNum
     */
    public static function addSiteGoodNumText(User $user, Orm\Site $site, $prevMaxGoodNum)
    {
        if ($site->good_num > 100 && $site->good_num > $prevMaxGoodNum && $site->good_num % 100 == 0) {
            $text = sprintf('サイト「<a href="%s">%s</a>」へのいいねが%dに達しました！',
                route('サイト詳細', ['site' => $site->id]),
                $site->name,
                $site->good_num
            );

            self::insert($user->id, $text);
        }
    }

    /**
     * お気に入りサイトに登録してくれた
     *
     * @param User $user
     * @param Orm\Site $site
     * @param User $favoriteUser
     */
    public static function addSiteFavoriteText(user $user, Orm\Site $site, User $favoriteUser)
    {
        $text = sprintf('<a href="%s">%sさん</a>がサイト「<a href="%s">%s</a>」をお気に入りに登録しました！',
            $favoriteUser->id,
            $favoriteUser->name,
            route('サイト詳細', ['site' => $site->id]),
            $site->name
        );

        self::insert($user->id, $text);
    }

    /**
     * レビューにいいねしてくれた
     *
     * @param User $user
     * @param Orm\Review $review
     * @param Orm\GamePackage $package
     * @param User $goodUser
     */
    public static function addReviewGoodText(User $user, Orm\Review $review, Orm\GamePackage $package, User $goodUser)
    {
        if ($goodUser === null) {
            $text = sprintf('<a href="%s">%sのレビュー</a>がいいねされました。',
                route('レビュー詳細', ['review' => $review->id]),
                $package->name
            );
        } else {
            $text = sprintf('<a href="%s">%sさん</a>が<a href="%s">%sのレビュー</a>にいいねしてくれました。',
                route('プロフィール', ['showId' => $goodUser->show_id]),
                $goodUser->name,
                route('レビュー詳細', ['review' => $review->id]),
                $package->name
            );
        }

        self::insert($user->id, $text);
    }

    /**
     * レビューへのいいねが初めてn件を超えた
     *
     * @param User $user
     * @param Orm\Review $review
     * @param Orm\GamePackage $package
     * @param $prevMaxGoodNum
     */
    public static function addReviewGoodNumText(User $user, Orm\Review $review, Orm\GamePackage $package, $prevMaxGoodNum)
    {
        if ($review->max_good_num > 1 && $prevMaxGoodNum < $review->max_good_num && $review->max_good_num % 100 == 0) {
            $text = sprintf('<a href="%s">%sのレビュー</a>へのいいねが%d件に達しました。',
                route('レビュー詳細', ['review' => $review->id]),
                $package->name,
                $review->max_good_num
            );

            self::insert($user->id, $text);
        }
    }

    /**
     * ユーザーコミュニティに投稿したトピックに返信があった
     *
     * @param User $user
     * @param Orm\UserCommunity $userCommunity
     * @param Orm\UserCommunityTopic $topic
     */
    public static function addUserCommunityTopicResponseText(User $user, Orm\UserCommunity $userCommunity, Orm\UserCommunityTopic $topic)
    {
        $text = sprintf('コミュニティ「<a href="%s">%s</a>」に<a href="%s">投稿したトピック</a>に返信がありました。',
            route('ユーザーコミュニティ', ['uc' => $userCommunity->id]),
            $userCommunity->name,
            route('ユーザーコミュニティ投稿詳細', ['uc' => $userCommunity->id, 'uct' => $topic->id])
        );

        self::insert($user->id, $text);
    }

    /**
     * ゲームコミュニティに投稿したトピックに返信があった
     *
     * @param User $user
     * @param Orm\GameSoft $soft
     * @param Orm\GameCommunityTopic $topic
     */
    public static function addGameCommunityTopicResponseText(User $user, Orm\GameSoft $soft, Orm\GameCommunityTopic $topic)
    {
        $text = sprintf('コミュニティ「<a href="%s">%s</a>」に<a href="%s">投稿したトピック</a>に返信がありました。',
            route('ゲームコミュニティ', ['soft' => $soft->id]),
            $soft->name,
            route('ゲームコミュニティ投稿詳細', ['soft' => $soft->id, 'topic' => $topic->id])
        );

        self::insert($user->id, $text);
    }

    /**
     * サイト登録が完了した
     *
     * @param User $user
     * @param Orm\Site $site
     */
    public static function addSiteRegisteredText(User $user, Orm\Site $site)
    {
        $text = sprintf('「<a href="%s">%s</a>」の登録が完了しました。',
            route('サイト詳細', ['site' => $site->id]),
            $site->name
        );

        self::insert($user->id, $text);
    }

    /**
     * サイト更新が完了した
     *
     * @param User $user
     * @param Orm\Site $site
     */
    public static function addSiteUpdatedText(User $user, Orm\Site $site)
    {
        $text = sprintf('「<a href="%s">%s</a>」を更新しました。',
            route('サイト詳細', ['site' => $site->id]),
            $site->name
        );

        self::insert($user->id, $text);
    }

    /**
     * サイト承認してね
     *
     * @param User $user
     * @param Orm\Site $site
     */
    public static function addSiteApproveText(User $user, Orm\Site $site)
    {
        $text = sprintf('サイト承認を行ってください。<a href="%s">%s</a>',
            route('サイト判定', ['site' => $site->id]),
            $site->name
        );

        self::insert($user->id, $text);
    }

    /**
     * サイトをリジェクトしました
     *
     * @param User $user
     * @param Orm\Site $site
     */
    public static function addSiteRejectText(User $user, Orm\Site $site)
    {
        $text = sprintf('「<a href="%s">%s</a>」を登録できませんでした。詳しくは詳細画面でご確認ください。',
            route('サイト詳細', ['site' => $site->id]),
            $site->name
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
            self::getDB()->to_me_timeline->insertOne([
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