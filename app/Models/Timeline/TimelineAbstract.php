<?php
/**
 * 基底タイムラインモデル
 */

namespace Hgs3\Models\Timeline;

use Hgs3\Models\MongoDB\Collection;

abstract class TimelineAbstract
{
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