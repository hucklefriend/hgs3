<?php
/**
 * お気に入りサイトタイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Illuminate\Support\Facades\Log;
use Hgs3\Models\Orm;

class FavoriteSite extends TimelineAbstract
{
    /**
     * サイト更新
     *
     * @param Orm\Site $site
     */
    public static function addUpdateSiteText(Orm\Site $site)
    {
        $text = sprintf('お気に入りに登録しているサイト「<a href="%s">%s</a>」が更新されました。',
            route('サイト詳細', ['site' => $site->id]),
            $site->name
        );

        self::insert($site->id, $text);
    }

    /**
     * いいねがn件に達した
     *
     * @param Orm\Site $site
     * @param int $prevMaxGoodNum
     */
    public static function addGoodNumText(Orm\Site $site, $prevMaxGoodNum)
    {
        if ($site->good_num > 0 && $prevMaxGoodNum < $site->good_num && $site->good_num % 100 == 0) {
            $text = sprintf('お気に入りに登録しているサイト「<a href="%s">%s</a>」へのいいねが%dに達しました！',
                route('サイト詳細', ['site' => $site->id]),
                $site->name,
                $site->good_num
            );

            self::insert($site->id, $text);
        }
    }

    /**
     * アクセス数がn件を超えた
     *
     * @param Orm\Site $site
     * @param int $outCount
     */
    public static function addAccessNumText(Orm\Site $site, $outCount)
    {
        if ($outCount > 100 && $outCount % 100 == 1) {
            $text = sprintf('お気に入りに登録しているサイト「<a href="%s">%s</a>」へのアクセス数が%dを超えました！',
                route('サイト詳細', ['site' => $site->id]),
                $site->name,
                intval($outCount / 100) * 100
            );

            self::insert($site->id, $text);
        }
    }

    /**
     * サイトが削除された
     *
     * @param Orm\Site $site
     */
    public static function addDeleteText(Orm\Site $site)
    {
        $text = sprintf('お気に入りに登録しているサイト「<a href="%s">%s</a>」が削除されました。',
            route('サイト詳細', ['site' => $site->id]),
            $site->name
        );

        self::insert($site->id, $text);
    }

    /**
     * データ登録
     *
     * @param int $siteId
     * @param string $text
     * @return bool
     */
    private static function insert($siteId, $text)
    {
        try {
            self::getDB()->favorite_site_timeline->insertOne([
                'site_id' => $siteId,
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