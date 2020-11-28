<?php
/**
 * ユーザーのテストデータ生成
 */

namespace Hgs3\Models\Test;
use Hgs3\Constants\Site\ApprovalStatus;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm;

class Site
{
    /**
     * サイトIDの配列を取得
     *
     * @return array
     */
    public static function getIds()
    {
        return DB::table('sites')
            ->select('id')
            ->get()
            ->pluck('id');
    }

    /**
     * サイトORMの配列を取得
     *
     * @return array
     */
    public static function get()
    {
        return Orm\Site::all();
    }

    /**
     * 承認済みサイトORMの配列を取得
     *
     * @return array
     */
    public static function getOpen()
    {
        return Orm\Site::where('approval_status', ApprovalStatus::OK)
            ->get();
    }
}