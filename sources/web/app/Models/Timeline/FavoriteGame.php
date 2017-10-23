<?php
/**
 * お気に入りゲームタイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Hgs3\Models\User;
use Illuminate\Support\Facades\Log;
use Hgs3\Models\Orm;

class FavoriteGame extends TimelineAbstract
{
    /**
     * ゲームソフト追加
     *
     * @param Orm\GameSoft $soft
     */
    public static function addNewGameSoftText(Orm\GameSoft $soft)
    {
        $text = sprintf('「<a href="%s">%s</a>」が追加されました。',
            url2('game/soft/' . $soft->id),
            $soft->name
        );

        self::insert($soft->id, $text);
    }

    /**
     * 同じシリーズのゲームソフトが追加された
     *
     * @param Orm\GameSoft $soft
     * @param Orm\GameSeries $series
     */
    public static function addSameSeriesGameText(Orm\GameSoft $soft, Orm\GameSeries $series)
    {
        $text = sprintf('<a href="%s">%s</a>シリーズのゲーム「<a href="%s">%s</a>」が追加されました。',
            url2('game/series/' . $series->id),
            $series->name,
            url2('game/soft/' . $soft->id),
            $soft->name
        );

        self::insert($soft->id, $text);
    }

    /**
     * ゲームソフト更新
     *
     * @param Orm\GameSoft $soft
     */
    public static function addUpdateGameSoftText(Orm\GameSoft $soft)
    {
        $text = sprintf('「<a href="%s">%s</a>」の情報が更新されました。',
            url2('game/soft/' . $soft->id),
            $soft->name
        );

        self::insert($soft->id, $text);
    }

    /**
     * お気に入りゲーム登録
     *
     * @param Orm\GameSoft $soft
     * @param User $user
     */
    public static function addFavoriteGameText(Orm\GameSoft $soft, User $user)
    {
        $text = sprintf('<a href="%s">%sさん</a>が<a href="%s">%s</a>をお気に入りゲームに登録しました。',
            url2('user/profile/' . $user->id),
            $user->name,
            url2('game/soft/' . $soft->id),
            $soft->name
        );

        self::insert($soft->id, $text);
    }

    /**
     * レビュー投稿
     *
     * @param Orm\GameSoft $soft
     * @param Orm\Review $review
     */
    public static function addNewReviewText(Orm\GameSoft $soft, Orm\Review $review)
    {
        $text = sprintf('<a href="%s">%s</a>に<a href="%s">新しいレビュー</a>%sが投稿されました。',
            url2('game/soft/' . $soft->id),
            $soft->name,
            url2('review/' . $review->id),
            $review->is_spoiler ? '(ネタバレあり)' : ''
        );

        self::insert($soft->id, $text);
    }

    /**
     * 新着サイト
     *
     * @param Orm\GameSoft $soft
     * @param Orm\Site $site
     */
    public static function addNewSiteText(Orm\GameSoft $soft, Orm\Site $site)
    {
        $text = sprintf('<a href="%s">%s</a>を扱うサイト「<a href="%s">%s</a>」が登録されました。',
            url2('game/soft/' . $soft->id),
            $soft->name,
            url2('site/detail' . $site->id),
            $site->name
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
            self::getDB()->favorite_game_timeline->insertOne([
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