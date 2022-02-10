<?php
/**
 * お知らせコントローラー
 */

namespace Hgs3\Http\Controllers\System;

use Hgs3\Http\Requests\Game\GameCompanyRequest;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\System\NoticeRequest;
use Hgs3\Models\Game\Collection;
use Hgs3\Models\Game\Package;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    /**
     * 一覧
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('system.notice.index', [
            'notices' => Orm\SystemNotice::getNoticeIndexPageData()
        ]);
    }

    /**
     * 詳細
     *
     * @param Orm\SystemNotice $notice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Orm\SystemNotice $notice)
    {
        return view('system.notice.detail', [
            'notice' => $notice
        ]);
    }
}
