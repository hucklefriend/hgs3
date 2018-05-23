<?php
/**
 * ORM: site_good_histories
 */

namespace Hgs3\Models\Orm;

class SiteGoodHistory extends \Eloquent
{
    /**
     * 特定ユーザーのデータ数を取得
     *
     * @param $userId
     * @return int
     */
    public static function getNumByUser($userId)
    {
        return self::where('user_id', $userId)
            ->count('site_id');
    }
}
