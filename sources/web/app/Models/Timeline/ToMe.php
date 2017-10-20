<?php
/**
 * 自分のタイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Illuminate\Support\Facades\Log;

class ToMe extends TimelineAbstract
{
    /**
     * 誰かにフォローされた
     *
     * @param int $userId
     * @param int $followerId
     * @param string $followerName
     */
    public static function addFollowerText($userId, $followerId, $followerName)
    {
        self::setUserName($followerId, $followerName);

        $text = sprintf('<a href="%s">%sさん</a>にフォローされました',
            url2('user/profile/' . $followerId),
            $followerName
        );

        self::insert($userId, $text);
    }

    /**
     * サイトにいいねされた
     *
     * @param int $userId
     * @param int $goodUserId
     * @param string $goodUserName
     * @param int $siteId
     * @param string $siteName
     */
    public static function addSiteGoodText($userId, $goodUserId, $goodUserName, $siteId, $siteName)
    {
        if ($goodUserId != null) {
            self::setUserName($goodUserId, $goodUserName);
        }
        self::setSiteName($siteId, $siteName);

        if ($goodUserId != null) {
            $text = sprintf('サイト「<a href="%s">%s</a>」がいいねされました。',
                url2('site/detail/' . $siteId),
                $siteName
            );
        } else {
            $text = sprintf('<a href="%s">%sさん</a>がサイト「<a href="%s">%s</a>」にいいねしてくれました。',
                url2('user/profile/' . $goodUserId),
                $goodUserName,
                url2('site/detail/' . $siteId),
                $siteName
            );
        }

        self::insert($userId, $text);
    }

    /**
     * サイトへのいいね数がn件を超えた
     *
     * @param $userId
     * @param $siteId
     * @param $siteName
     * @param $goodNum
     */
    public static function addSiteGoodNumText($userId, $siteId, $siteName, $goodNum)
    {
        self::setSiteName($siteId, $siteName);

        $text = sprintf('サイト「<a href="%s">%s</a>」へのいいねが%dに達しました！',
            url2('site/detail/' . $siteId),
            $siteName,
            $goodNum
        );

        self::insert($userId, $text);
    }

    /**
     * お気に入りサイトに登録してくれた
     *
     * @param $userId
     * @param $siteId
     * @param $siteName
     * @param $favoriteUserId
     * @param $favoriteUserName
     */
    public static function addSiteFavoriteText($userId, $siteId, $siteName, $favoriteUserId, $favoriteUserName)
    {
        self::setSiteName($siteId, $siteName);
        self::setUserName($favoriteUserId, $favoriteUserName);

        $text = sprintf('<a href="%s">%sさん</a>がサイト「<a href="%s">%s</a>」をお気に入りに登録しました！',
            $favoriteUserId,
            $favoriteUserName,
            url2('site/detail/' . $siteId),
            $siteName
        );

        self::insert($userId, $text);
    }

    /**
     * レビューにいいねしてくれた
     *
     * @param $userId
     * @param $reviewId
     * @param $packageId
     * @param $packageName
     * @param $goodUserId
     * @param $goodUserName
     */
    public static function addReviewGoodText($userId, $reviewId, $packageId, $packageName, $goodUserId, $goodUserName)
    {
        if ($goodUserId != null) {
            self::setUserName($goodUserId, $goodUserName);
        }
        self::setPackageName($packageId, $packageName);

        if ($goodUserId != null) {
            $text = sprintf('<a href="%s">%sのレビュー</a>がいいねされました。',
                url2('review/detail/' . $reviewId),
                $packageName
            );
        } else {
            $text = sprintf('<a href="%s">%sさん</a>が<a href="%s">%sのレビュー</a>にいいねしてくれました。',
                url2('user/profile/' . $goodUserId),
                $goodUserName,
                url2('review/detail/' . $reviewId),
                $packageName
            );
        }

        self::insert($userId, $text);
    }

    /**
     * レビューへのいいねが初めてn件を超えた
     *
     * @param int $userId
     * @param int $reviewId
     * @param int $packageId
     * @param string $packageName
     * @param int $goodNum
     */
    public static function addReviewGoodNumText($userId, $reviewId, $packageId, $packageName, $goodNum)
    {
        self::setPackageName($packageId, $packageName);

        $text = sprintf('<a href="%s">%sのレビュー</a>へのいいねが%d件に達しました。',
            url2('review/detail/' . $reviewId),
            $packageName,
            $goodNum
        );

        self::insert($userId, $text);
    }

    /**
     * ユーザーコミュニティに投稿したトピックに返信があった
     *
     * @param $userId
     * @param $userCommunityId
     * @param $userCommunityName
     * @param $topicId
     */
    public static function addUserCommunityTopicResponseText($userId, $userCommunityId, $userCommunityName, $topicId)
    {
        self::setCommunityName($userCommunityId, $userCommunityName);

        $text = sprintf('コミュニティ「<a href="%s">%s</a>」に<a href="%s">投稿したトピック</a>に返信がありました。',
            url2('community/u/' . $userCommunityId),
            $userCommunityName,
            url2('community/u/' . $userCommunityId . '/topic/' . $topicId)
        );

        self::insert($userId, $text);
    }

    /**
     * ゲームコミュニティに投稿したトピックに返信があった
     *
     * @param $userId
     * @param $gameId
     * @param $gameName
     * @param $topicId
     */
    public static function addGameCommunityTopicResponseText($userId, $gameId, $gameName, $topicId)
    {
        self::setGameName($gameId, $gameName);

        $text = sprintf('コミュニティ「<a href="%s">%s</a>」に<a href="%s">投稿したトピック</a>に返信がありました。',
            url2('community/g/' . $gameId),
            $gameName,
            url2('community/g/' . $gameId . '/topic/' . $topicId)
        );

        self::insert($userId, $text);
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