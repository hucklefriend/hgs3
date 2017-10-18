<?php
/**
 * ゲームタイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Illuminate\Support\Facades\Log;

class Game extends TimelineAbstract
{
    /**
     * ゲームソフト追加
     *
     * @param int $gameId
     * @param string $gameName
     */
    public static function addNewGameSoftText($gameId, $gameName)
    {
        self::setGameName($gameId, $gameName);

        $text = sprintf('「<a href="%s">%s</a>」が追加されました。',
            url2('game/soft') . '/' . $gameId,
            $gameName
        );

        $document = [
            'text'    => $text,
            'game_id' => $gameId,
            'time'    => microtime(true)
        ];

        self::insert($document);
    }

    /**
     * 同じシリーズのゲームソフトが追加された
     *
     * @param int $gameId
     * @param string $gameName
     * @param int $seriesId
     * @param string $seriesName
     */
    public static function addSameSeriesGameText($gameId, $gameName, $seriesId, $seriesName)
    {
        self::setGameName($gameId, $gameName);
        self::setSeriesName($seriesId, $seriesName);

        $text = sprintf('<a href="%s">%s</a>シリーズのゲーム「<a href="%s">%s</a>」が追加されました。',
            url2('game/soft') . '/' . $gameId,
            $gameName
        );

        $document = [
            'text'    => $text,
            'game_id' => $gameId,
            'time'    => microtime(true)
        ];

        self::insert($document);
    }

    /**
     * ゲームソフト更新
     *
     * @param int $gameId
     * @param string $gameName
     */
    public static function addUpdateGameSoftText($gameId, $gameName)
    {
        self::setGameName($gameId, $gameName);

        $text = sprintf('「<a href="%s">%s</a>」の情報が更新されました。',
            url2('game/soft') . '/'.$gameId,
            $gameName
        );

        $document = [
            'text'    => $text,
            'game_id' => $gameId,
            'time'    => microtime(true)
        ];

        self::insert($document);
    }

    /**
     * お気に入りゲーム登録
     *
     * @param int $gameId
     * @param string $gameName
     * @param int $userId
     * @param string $userName
     */
    public static function addFavoriteGameText($gameId, $gameName, $userId, $userName)
    {
        self::setGameName($gameId, $gameName);
        self::setUserName($userId, $userName);

        $text = sprintf('<a href="%s">%sさん</a>が<a href="%s">%s</a>をお気に入りゲームに登録しました。',
            url2('user/profile/' . $userId),
            $userName,
            url2('game/soft/' . $gameId),
            $gameName
        );

        $document = [
            'text'    => $text,
            'game_id' => $gameId,
            'time'    => microtime(true)
        ];

        self::insert($document);
    }

    /**
     * レビュー投稿
     *
     * @param int $gameId
     * @param string $gameName
     * @param int $reviewId
     * @param bool $isSpoiler
     */
    public static function addNewReviewText($gameId, $gameName, $reviewId, $isSpoiler)
    {
        self::setGameName($gameId, $gameName);

        $text = sprintf('<a href="%s">%s</a>に<a href="%s">新しいレビュー</a>%sが投稿されました。',
            url2('game/soft/' . $gameId),
            $gameName,
            url2('review/' . $reviewId),
            $isSpoiler ? '(ネタバレあり)' : ''
        );

        $document = [
            'text'    => $text,
            'game_id' => $gameId,
            'time'    => microtime(true)
        ];

        self::insert($document);
    }

    /**
     * 新着サイト
     *
     * @param int $gameId
     * @param string $gameName
     * @param int $siteId
     * @param string $siteName
     */
    public static function addNewSiteText($gameId, $gameName, $siteId, $siteName)
    {
        self::setGameName($gameId, $gameName);
        self::setSiteName($siteId, $siteName);

        $text = sprintf('<a href="%s">%s</a>を扱うサイト「<a href="%s">%s</a>」が登録されました。',
            url2('game/soft/' . $gameId),
            $gameName,
            url2('site/detail' . $siteId),
            $siteName
        );

        $document = [
            'text'    => $text,
            'game_id' => $gameId,
            'time'    => microtime(true)
        ];

        self::insert($document);
    }

    /**
     * データ登録
     *
     * @param $document
     * @return bool
     */
    private static function insert($document)
    {
        try {
            self::getDB()->game_timeline->insertOne($document);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return true;
    }
}