<?php
/**
 * サイト承認モデル
 */

namespace Hgs3\Models\Site;

use Hgs3\Log;
use Hgs3\Models\Orm;
use Hgs3\Constants;
use Illuminate\Support\Facades\DB;

class Approval
{
    /**
     * 承認待ちのサイト数を取得
     *
     * @return int
     */
    public static function getWaitNum()
    {
        return Orm\Site::where('approval_status', Constants\Site\ApprovalStatus::WAIT)
            ->count();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getWaitList()
    {
        return Orm\Site::where('approval_status', Constants\Site\ApprovalStatus::WAIT)
            ->orderBy('id')
            ->paginate(30);
    }

    /**
     *
     *
     * @param Orm\Site $site
     * @param $message
     * @throws \Exception
     */
    public static function approve(Orm\Site $site, $message)
    {
        DB::beginTransaction();
        try {
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::exeptionError($e);
        }
    }

    public static function reject(Orm\Site $site, $message)
    {
        DB::beginTransaction();
        try {
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::exeptionError($e);
        }
    }
}