<?php
/**
 * ユーザータイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Illuminate\Support\Facades\Log;

class User extends TimelineAbstract
{
    /**
     * サイト登録
     *
     * @param int $userId
     * @param string $userName
     * @param int $siteId
     * @param string $siteName
     */
    public static function addAddSiteText($userId, $userName, $siteId, $siteName)
    {
        self::setUserName($userId, $userName);
        self::setSiteName($siteId, $siteName);

        $text = sprintf('<a href="%s">%sさん</a>が新しいサイト「<a href="%s">%s</a>」を登録しました。',
            url2('user/profile/' . $userId),
            $userName,
            url2('site/detail/' . $siteId),
            $siteName
        );

        self::insert($userId, $text);
    }

    /**
     * サイト更新
     *
     * @param int $userId
     * @param string $userName
     * @param int $siteId
     * @param string $siteName
     */
    public static function addUpdateSiteText($userId, $userName, $siteId, $siteName)
    {
        self::setUserName($userId, $userName);
        self::setSiteName($siteId, $siteName);

        $text = sprintf('<a href="%s">%sさん</a>がサイト「<a href="%s">%s</a>」の情報を更新しました。',
            url2('user/profile/' . $userId),
            $userName,
            url2('site/detail/' . $siteId),
            $siteName
        );

        self::insert($userId, $text);
    }

    /**
     * ゲームコミュニティ参加
     *
     * @param int $userId
     * @param string $userName
     * @param int $gameId
     * @param string $gameName
     */
    public static function addJoinGameCommunityText($userId, $userName, $gameId, $gameName)
    {
        self::setUserName($userId, $userName);
        self::setGameName($gameId, $gameName);

        $text = sprintf('<a href="%s">%sさん</a>がコミュニティ「<a href="%s">%s</a>」に参加しました。',
            url2('user/profile/' . $userId),
            $userName,
            url2('community/g/' . $gameId),
            $gameName
        );

        self::insert($userId, $text);
    }

    /**
     * ユーザーコミュニティ参加
     *
     * @param int $userId
     * @param string $userName
     * @param int $communityId
     * @param string $communityName
     */
    public static function addJoinUserCommunityText($userId, $userName, $communityId, $communityName)
    {
        self::setUserName($userId, $userName);
        self::setCommunityName($communityId, $communityName);

        $text = sprintf('<a href="%s">%sさん</a>がコミュニティ「<a href="%s">%s</a>」に参加しました。',
            url2('user/profile/' . $userId),
            $userName,
            url2('community/u/' . $communityId),
            $communityName
        );

        self::insert($userId, $text);
    }

    /**
     * ゲームコミュニティ脱退
     *
     * @param int $userId
     * @param string $userName
     * @param int $gameId
     * @param string $gameName
     */
    public static function addLeaveGameCommunityText($userId, $userName, $gameId, $gameName)
    {
        self::setUserName($userId, $userName);
        self::setGameName($gameId, $gameName);

        $text = sprintf('<a href="%s">%sさん</a>がコミュニティ「<a href="%s">%s</a>」を脱退しました。',
            url2('user/profile/' . $userId),
            $userName,
            url2('community/g/' . $gameId),
            $gameName
        );

        self::insert($userId, $text);
    }

    /**
     * ユーザーコミュニティ脱退
     *
     * @param int $userId
     * @param string $userName
     * @param int $communityId
     * @param string $gameName
     */
    public static function addLeaveUserCommunityText($userId, $userName, $communityId, $gameName)
    {
        self::setUserName($userId, $userName);
        self::setCommunityName($communityId, $communityName);

        $text = sprintf('<a href="%s">%sさん</a>がコミュニティ「<a href="%s">%s</a>」を脱退しました。',
            url2('user/profile/' . $userId),
            $userName,
            url2('community/g/' . $communityId),
            $gameName
        );

        self::insert($userId, $text);
    }

    /**
     * レビュー投稿
     *
     * @param $userId
     * @param $userName
     * @param $reviewId
     * @param $isSpoiler
     * @param $gameId
     * @param $gameName
     */
    public static function addWriteReviewText($userId, $userName, $reviewId, $isSpoiler, $gameId, $gameName)
    {
        self::setUserName($userId, $userName);
        self::setGameName($gameId, $gameName);

        $text = sprintf('<a href="%s">%sさん</a>が<a href="%s">%sのレビュー</a>%sを投稿しました。',
            url2('user/profile/' . $userId),
            $userName,
            url2('review/detail/' . $reviewId),
            $gameName,
            $isSpoiler ? '(ネタバレあり)' : ''
        );

        self::insert($userId, $text);
    }

    /**
     * レビュー投稿
     *
     * @param $userId
     * @param $userName
     * @param $gameId
     * @param $gameName
     */
    public static function addAddFavoriteGameText($userId, $userName, $gameId, $gameName)
    {
        self::setUserName($userId, $userName);
        self::setGameName($gameId, $gameName);

        $text = sprintf('<a href="%s">%sさん</a>が<a href="%s">%s</a>をお気に入りゲームに登録しました。',
            url2('user/profile/' . $userId),
            $userName,
            url2('game/soft/' . $gameId),
            $gameName
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
            self::getDB()->user_timeline->insertOne([
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