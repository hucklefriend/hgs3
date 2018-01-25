<?php
/**
 * サイトタイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Hgs3\Log;
use Hgs3\Models\Orm;

class Site extends TimelineAbstract
{
    /**
     * 新着サイト
     *
     * @param Orm\Site $site
     */
    public static function addNewArrivalText(Orm\Site $site)
    {
        $text = sprintf('新着サイトです！「<a href="%s">%s</a>」',
            route('サイト詳細', ['site' => $site->id]),
            $site->name
        );

        self::insert($site->id, $text);
    }

    /**
     * 更新サイト
     *
     * @param Orm\Site $site
     * @param int $prevMaxGoodNum
     */
    public static function addUpdateText(Orm\Site $site)
    {
        $text = sprintf('「<a href="%s">%s</a>」が更新されました！',
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
            $text = sprintf('「<a href="%s">%s</a>」へのいいねが%dに達しました！',
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
            $text = sprintf('「<a href="%s">%s</a>」へのアクセス数が%dを超えました！',
                route('サイト詳細', ['site' => $site->id]),
                $site->name,
                intval($outCount / 100) * 100
            );

            self::insert($site->id, $text);
        }
    }

    /**
     * データ登録
     *
     * @param int $siteId
     * @param string $text
     */
    private static function insert($siteId, $text)
    {
        try {
            self::getDB()->site_timeline->insertOne([
                'site_id'  => $siteId,
                'text'     => $text,
                'dateTime' => date('Y-m-d H:i'),
                'time'     => microtime(true)
            ]);
        } catch (\Exception $e) {
            Log::exceptionError($e);
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

        return self::getDB()->site_timeline->find($filter, $options)->toArray();
    }
}