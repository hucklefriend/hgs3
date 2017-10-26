<?php
/**
 * サイトへのいいね
 */

namespace Hgs3\Models\Site;

use Hgs3\Models\MongoDB\Collection;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Support\Facades\Log;

class Footprint
{
    /**
     * 履歴を取得
     *
     * @param int $siteId
     * @param int $limit
     * @param int $skip
     * @return array
     */
    public static function getBySite($siteId, $limit, $skip)
    {
        $filter = [
            'site_id' => $siteId
        ];
        $options = [
            'limit' => $limit,
            'skip'  => $skip
        ];

        return self::getCollection()->find($filter, $options)->toArray();
    }

    /**
     * 履歴の件数を取得
     *
     * @param int $siteId
     * @return int
     */
    public static function getNumBySite($siteId)
    {
        $filter = [
            'site_id' => $siteId
        ];

        return self::getCollection()->count($filter);
    }

    /**
     * 履歴を取得
     *
     * @param int $userId
     * @param int $time
     * @param int $num
     * @return array
     */
    public static function getByUser($userId, $time, $num)
    {
        $filter = [
            'user_id'          => $userId,
            'update_timestamp' => ['$lt' => $time]
        ];
        $options = [
            'sort'  => ['time' => -1],
            'limit' => $num,
        ];

        return self::getCollection()->find($filter, $options)->toArray();
    }

    /**
     * 足跡を登録
     *
     * @param Orm\Site $site
     * @param ?User $user
     * @return bool
     */
    public static function add(Orm\Site $site, ?User $user)
    {
        try {
            $document = [
                'site_id' => $site->id,
                'user_id' => $user ? $user->id : null,
                'time'    => time()
            ];
            self::getCollection()->insertOne($document);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return false;
        }

        return true;
    }

    /**
     * 削除
     *
     * @param $siteId
     */
    public static function delete($siteId)
    {
        $filter = [
            'site_id' => $siteId
        ];

        self::getCollection()->deleteMany($filter);
    }

    /**
     * コレクションを取得
     *
     * @return \MongoDB\Collection
     */
    private static function getCollection()
    {
        return Collection::getInstance()->getDatabase()->site_footprint;
    }
}