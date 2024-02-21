<?php
/**
 * 管理コントローラー
 */

namespace Hgs3\Http\Controllers\Management;

use Hgs3\Models\Orm;
use Hgs3\Models\Site;
use Hgs3\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Hgs3\Http\Controllers\AbstractManagementController;
use Illuminate\View\View;

class ManagementController extends AbstractManagementController
{
    /**
     * 管理
     *
     * @return Factory|View
     */
    public function index(): Factory|View
    {
        // ローカル環境でのみ、id:1で自動ログインする
        if (App::environment('local')) {
            Auth::loginUsingId(1, true);
        }

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
