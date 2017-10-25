<?php
/**
 * 基底タイムラインモデル
 */

namespace Hgs3\Models\Site;

use Hgs3\Models\MongoDB\Collection;
use Hgs3\Models\Orm;
use Hgs3\Models\Timeline;
use Illuminate\Support\Facades\DB;

class UpdateHistories
{
    /**
     * 履歴を取得
     *
     * @param Orm\Site $site
     * @param int $time
     * @param int $num
     * @return array
     */
    public static function get(Orm\Site $site, $time, $num)
    {
        $filter = [
            'soft_id'          => $site->id,
            'update_timestamp' => ['$lt' => $time]
        ];
        $options = [
            'sort'  => ['time' => -1],
            'limit' => $num,
        ];

        return self::getCollection()->find($filter, $options)->toArray();
    }

    /**
     * サイト更新履歴に登録
     *
     * @param Orm\Site $site
     * @param $comment
     * @return bool
     */
    public static function add(Orm\Site $site, $comment)
    {
        $collection = self::getCollection();

        // MongoDBに登録
        try {
            $document = [
                'site_id'          => $site->id,
                'comment'          => $comment,
                'update_timestamp' => time()
            ];
            $result = $collection->insertOne($document);
        } catch (\Exception $e) {
            return false;
        }

        DB::beginTransaction();
        try {
            // サイト情報を更新
            DB::table('sites')
                ->where('id', $site->id)
                ->update([
                    'updated_timestamp' => time(),
                    'updated_at'        => DB::raw('CURRENT_TIMESTAMP')
                ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            // 先ほど登録した履歴を削除
            $collection->deleteOne(['_id' => $result->getInsertedId()]);

            return false;
        }

        // タイムラインに登録
        Timeline\FavoriteSite::addUpdateSiteText($site);

        return true;
    }

    /**
     * コレクションを取得
     *
     * @return \MongoDB\Collection
     */
    private static function getCollection()
    {
        return Collection::getInstance()->getDatabase()->site_update_history;
    }
}