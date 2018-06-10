<?php
/**
 * 管理コントローラー
 */

namespace Hgs3\Http\Controllers;

use Hgs3\Models\Orm;
use Hgs3\Models\Site;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * 管理メニュー
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin', [
            'approvalWaitNum' => Site\Approval::getWaitNum(),
            'reviewUrlWaitNum' => Orm\ReviewWaitUrl::all()->count(),
        ]);
    }


    public function hgs2SiteChecker()
    {
        $sites = DB::table('hgs2.hgs_u_site')
            ->orderBy('id')
            ->get();

        return view('admin.hgs2SiteChecker', ['sites' => $sites]);
    }
}
