<?php
/**
 * [管理]お知らせ
 */

namespace Hgs3\Http\Controllers\Management\System;

use Hgs3\Http\Controllers\AbstractManagementController;
use Hgs3\Http\Requests\System\NoticeRequest;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Pagination\Paginator;

class NoticeController extends AbstractManagementController
{
    /**
     * インデックス
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $notices = Orm\SystemNotice::orderByDesc('id')
            ->paginate(20);

        return view('management.system.notice.index', [
            'notices' => $notices
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
        return view('management.system.notice.detail', [
            'notice' => $notice
        ]);
    }

    /**
     * 追加画面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('management.system.notice.add');
    }

    /**
     * データ追加
     *
     * @param NoticeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(NoticeRequest $request)
    {
        $notice = new Orm\SystemNotice();
        $notice->title = $request->input('title');
        $notice->message = $request->input('message');
        $notice->type = $request->input('type', 0);
        $notice->open_at = $request->input('open_at');
        $notice->close_at = $request->input('close_at');
        $notice->top_start_at = $request->input('top_start_at');
        $notice->top_end_at = $request->input('top_end_at');

        $notice->save();

        return redirect()->route('管理-システム-お知らせ');
    }

    /**
     * 編集画面
     *
     * @param Orm\SystemNotice $notice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Orm\SystemNotice $notice)
    {
        $notice->open_at = format_date_local($notice->open_at);
        $notice->close_at = format_date_local($notice->close_at);
        $notice->top_start_at = format_date_local($notice->top_start_at);
        $notice->top_end_at = format_date_local($notice->top_end_at);

        return view('management.system.notice.edit', [
            'notice' => $notice
        ]);
    }

    /**
     * データ更新
     *
     * @param NoticeRequest $request
     * @param Orm\SystemNotice $notice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(NoticeRequest $request, Orm\SystemNotice $notice)
    {
        $notice->title = $request->input('title');
        $notice->message = $request->input('message');
        $notice->type = $request->input('type', 0);
        $notice->open_at = $request->input('open_at');
        $notice->close_at = $request->input('close_at');
        $notice->top_start_at = $request->input('top_start_at');
        $notice->top_end_at = $request->input('top_end_at');

        $notice->save();

        return redirect()->route('管理-システム-お知らせ詳細', $notice);
    }

    /**
     * 削除
     *
     * @param Orm\SystemNotice $notice
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Orm\SystemNotice $notice)
    {
        $notice->delete();

        return redirect()->route('管理-システム-お知らせ');
    }
}
