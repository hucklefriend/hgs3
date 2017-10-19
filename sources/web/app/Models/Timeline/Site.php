<?php
/**
 * サイトタイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Illuminate\Support\Facades\Log;

class Site extends TimelineAbstract
{
    /**
     * サイト更新
     *
     * @param int $siteId
     * @param string $siteName
     */
    public static function addUpdateSiteText($siteId, $siteName)
    {
        self::setSiteName($siteId, $siteName);

        $text = sprintf('お気に入りに登録しているサイト「<a href="%s">%s</a>」が更新されました。',
            url2('site/detail/' . $siteId),
            $siteName
        );

        self::insert($siteId, $text);
    }

    /**
     * いいねがn件に達した
     *
     * @param int $siteId
     * @param string $siteName
     * @param int $goodNum
     * @param int $maxGoodNum
     */
    public static function addGoodNumText($siteId, $siteName, $goodNum, $maxGoodNum)
    {
        if ($goodNum > 100 && $maxGoodNum < $goodNum && $goodNum % 100 == 0) {
            $text = sprintf('お気に入りに登録しているサイト「<a href="%s">%s</a>」へのいいねが%dに達しました！',
                url2('site/detail/' . $siteId),
                $siteName,
                $goodNum
            );

            self::insert($siteId, $text);
        }
    }

    /**
     * アクセス数がn件を超えた
     *
     * @param int $siteId
     * @param string $siteName
     * @param int $outCount
     */
    public static function addAccessNumText($siteId, $siteName, $outCount)
    {
        if ($outCount > 100 && $outCount % 100 == 1) {
            $text = sprintf('お気に入りに登録しているサイト「<a href="%s">%s</a>」へのアクセス数が%dを超えました！',
                url2('site/detail/' . $siteId),
                $siteName,
                intval($outCount / 100) * 100
            );

            self::insert($siteId, $text);
        }
    }

    /**
     * サイトが削除された
     *
     * @param int $siteId
     * @param string $siteName
     */
    public static function addDeleteText($siteId, $siteName)
    {
        $text = sprintf('お気に入りに登録しているサイト「<a href="%s">%s</a>」が削除されました。',
            url2('site/detail/' . $siteId),
            $siteName
        );

        self::insert($siteId, $text);
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
            self::getDB()->site_timeline->insertOne([
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