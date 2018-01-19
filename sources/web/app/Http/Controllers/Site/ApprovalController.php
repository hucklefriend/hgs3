<?php
/**
 * サイト承認コントローラー
 */


namespace Hgs3\Http\Controllers\Site;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Site;
use Hgs3\Models\Orm;

class ApprovalController extends Controller
{
    /**
     * トップ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('site.approval.index', Site\Approval::getWaitList());
    }


    public function judge(Orm\Site $site)
    {

    }

    /**
     * 承認
     *
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Orm\Site $site)
    {
        return redirect()->back();
    }

    /**
     * 拒否
     *
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Orm\Site $site)
    {
        return redirect()->back();
    }
}
