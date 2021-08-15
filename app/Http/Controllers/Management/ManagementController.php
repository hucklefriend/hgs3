<?php
/**
 * 管理コントローラー
 */

namespace Hgs3\Http\Controllers\Management;

use Hgs3\Models\Orm;
use Hgs3\Models\Site;
use Illuminate\Support\Facades\DB;
use Hgs3\Http\Controllers\AbstractManagementController;

class ManagementController extends AbstractManagementController
{
    /**
     * 管理
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('management/index');
    }

    public function hgs2SiteChecker()
    {
        $sites = DB::table('hgs2.hgs_u_site')
            ->orderBy('id')
            ->get();

        return view('management.hgs2SiteChecker', ['sites' => $sites]);
    }
}
