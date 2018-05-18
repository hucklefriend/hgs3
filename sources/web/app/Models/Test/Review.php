<?php
/**
 * レビュー
 */

namespace Hgs3\Models\Test;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Review
{
    /**
     * レビューIDの配列を取得
     *
     * @return array
     */
    public static function getIds()
    {
        return DB::table('reviews')
            ->select('id')
            ->get()
            ->pluck('id');
    }

    /**
     * レビューの配列を取得
     *
     * @return array
     */
    public static function get()
    {
        return Orm\Review::all();
    }
}