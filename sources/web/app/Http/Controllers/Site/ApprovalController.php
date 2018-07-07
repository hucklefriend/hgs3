<?php
/**
 * サイト承認コントローラー
 */


namespace Hgs3\Http\Controllers\Site;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Site;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    /**
     * トップ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('site.approval.index', [
            'sites' => Site\Approval::getWaitList()
        ]);
    }

    /**
     * 判定画面
     *
     * @param Orm\Site $site
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function judge(Orm\Site $site)
    {
        // 更新履歴
        $updateHistories = Orm\SiteUpdateHistory::where('site_id', $site->id)
            ->orderBy('site_updated_at', 'DESC')
            ->take(3)
            ->get();

        return view('site.approval.judge', [
            'site'        => $site,
            'handleSofts' => Site::getSoftWithOriginalPackage($site->id, false),
            'webMaster'   => User::find($site->user_id),
            'isWebMaster' => false,
            'isFavorite'  => false,
            'favoriteNum' => 0,
            'isGood'      => false,
            'updateHistories' => $updateHistories
        ]);
    }

    /**
     * 承認
     *
     * @param Request $request
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function approve(Request $request, Orm\Site $site)
    {
        Site\Approval::approve($site, '');

        return redirect()->route('承認待ちサイト一覧');
    }

    /**
     * 拒否
     *
     * @param Request $request
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function reject(Request $request, Orm\Site $site)
    {
        $message = $request->input('message', '');
        Site\Approval::reject($site, $message);



        return redirect()->route('承認待ちサイト一覧');
    }
}
