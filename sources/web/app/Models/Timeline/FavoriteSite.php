<?php
/**
 * サイトタイムラインモデル
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
            url2('site/detail/' . $site->id),
            $site->name
        );

        self::insert($site->id, $text);
    }

    /**
     * いいねがn件に達した
     *
     * @param Orm\Site $site
     * @param int $goodNum
     * @param int $prevMaxGoodNum
     */
    public static function addGoodNumText(Orm\Site $site, $goodNum, $prevMaxGoodNum)
    {
        if ($goodNum > 100 && $prevMaxGoodNum < $goodNum && $goodNum % 100 == 0) {
            $text = sprintf('お気に入りに登録しているサイト「<a href="%s">%s</a>」へのいいねが%dに達しました！',
                url2('site/detail/' . $site->id),
                $site->name,
                $goodNum
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
                url2('site/detail/' . $site->id),
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
            url2('site/detail/' . $site->id),
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