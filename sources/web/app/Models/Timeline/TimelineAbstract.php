<?php
/**
 * 基底タイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Hgs3\Models\MongoDB\Collection;
use Hgs3\Models\Orm;
use Hgs3\User;


abstract class TimelineAbstract
{
    /**
     * ゲーム名を取得
     *
     * @param int $gameId
     * @param string $gameName
     */
    protected static function setGameName($gameId, &$gameName)
    {
        if (empty($gameName)) {
            $game = Orm\Game::find($gameId);
            $gameName = $game !== null ? $game->name : '';
        }
    }

    /**
     * シリーズ名を取得
     *
     * @param int $seriesId
     * @param string $seriesName
     */
    protected static function setSeriesName($seriesId, &$seriesName)
    {
        if (empty($gameName)) {
            $series = Orm\GameSeries::find($seriesId);
            $seriesName = $series !== null ? $series->name : '';
        }
    }

    /**
     * サイト名を取得
     *
     * @param int $siteId
     * @param string $siteName
     */
    protected static function setSiteName($siteId, &$siteName)
    {
        if (empty($siteName)) {
            $site = Orm\Site::find($siteId);
            $siteName = $site !== null ? $site->name : '';
        }
    }

    /**
     * ユーザー名を取得
     *
     * @param int $userId
     * @param string $userName
     */
    protected static function setUserName($userId, &$userName)
    {
        if (empty($userName)) {
            $user = User::find($userId);
            $userName = $user !== null ? $user->name : '';
        }
    }

    /**
     * コミュニティ名を取得
     *
     * @param int $communityId
     * @param string $communityName
     */
    protected static function setCommunityName($communityId, &$communityName)
    {
        if (empty($communityName)) {
            $community = Orm\UserCommunity::find($communityId);
            $communityName = $community !== null ? $community->name : '';
        }
    }

    /**
     * データベースを取得
     *
     * @return \MongoDB\Database
     */
    protected static function getDB()
    {
        return Collection::getInstance()->getDatabase();
    }
}