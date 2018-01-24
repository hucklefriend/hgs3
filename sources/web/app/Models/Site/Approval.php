<?php
/**
 * サイト承認モデル
 */

namespace Hgs3\Models\Site;

use Hgs3\Models\Orm;
use Hgs3\Constants;
use Hgs3\Models\Site;
use Hgs3\Models\User;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Timeline;

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
     * 承認
     *
     * @param Orm\Site $site
     * @param $message
     * @return bool
     * @throws \Exception
     */
    public static function approve(Orm\Site $site, $message)
    {
        DB::beginTransaction();
        try {
            // 承認
            $site->approval_status = Constants\Site\ApprovalStatus::OK;
            $site->reject_reason = null;
            $site->save();

            // 検索インデックスに登録
            Site::saveHandleSofts($site);
            Site::saveSearchIndex($site);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            \Hgs3\Log::exceptionError($e);
            return false;
        }

        // タイムラインに登録
        $user = User::find($site->user_id);
        Site::saveNewSiteInformation($user, $site, explode(',', $site->handle_soft));

        return true;
    }

    /**
     * 拒否
     *
     * @param Orm\Site $site
     * @param $message
     * @return bool
     * @throws \Exception
     */
    public static function reject(Orm\Site $site, $message)
    {
        DB::beginTransaction();
        try {
            $site->approval_status = Constants\Site\ApprovalStatus::REJECT;
            $site->reject_reason = $message;
            $site->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Hgs3\Log::exceptionError($e);

            return false;
        }

        // タイムラインに登録
        $user = User::find($site->user_id);
        Timeline\ToMe::addSiteRejectText($user, $site);

        return true;
    }
}