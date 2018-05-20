<?php
/**
 * 管理コントローラー
 */

namespace Hgs3\Http\Controllers;

use Hgs3\Models\Orm;
use Hgs3\Models\Site;

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
}
