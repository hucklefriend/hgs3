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
        $notices = Orm\SystemNotice::select(['id', 'title', 'message', DB::raw('UNIX_TIMESTAMP(open_at) AS open_at_ts')])
            ->whereRaw('open_at <= NOW()')
            ->whereRaw('close_at >= NOW()')
            ->orderBy('open_at', 'DESC')
            ->paginate(20);

        return view('system.notice.index', [
            'notices' => $notices
        ]);
    }

    /**
     * 未来
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function future()
    {
        $notices = Orm\SystemNotice::select(['id', 'title', 'message', DB::raw('UNIX_TIMESTAMP(open_at) AS open_at_ts')])
            ->whereRaw('open_at > NOW()')
            ->orderBy('open_at', 'DESC')
            ->paginate(20);

        return view('system.notice.future', [
            'notices' => $notices
        ]);
    }

    /**
     * 過去(公開終了)
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function past()
    {
        $notices = Orm\SystemNotice::select(['id', 'title', 'message', DB::raw('UNIX_TIMESTAMP(open_at) AS open_at_ts')])
            ->whereRaw('close_at < NOW()')
            ->orderBy('open_at', 'DESC')
            ->paginate(20);

        return view('system.notice.future', [
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
        return view('system.notice.detail', [
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
        return view('system.notice.add');
    }

    /**
     * データ追加
     *
     * @param NoticeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function insert(NoticeRequest $request)
    {
        $notice = new Orm\SystemNotice();
        $notice->title = $request->input('title');
        $notice->message = $request->input('message');
        $notice->type = $request->input('type');
        $notice->open_at = $request->input('open_at');
        $notice->close_at = $request->input('close_at');
        $notice->top_start_at = $request->input('top_start_at');
        $notice->top_end_at = $request->input('top_end_at');

        $notice->save();

        return redirect()->route('お知らせ');
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

        return view('system.notice.edit', [
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
        $notice->type = $request->input('type');
        $notice->open_at = $request->input('open_at');
        $notice->close_at = $request->input('close_at');
        $notice->top_start_at = $request->input('top_start_at');
        $notice->top_end_at = $request->input('top_end_at');

        $notice->save();

        return redirect()->route('お知らせ内容', ['notice' => $notice->id]);
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

        return redirect()->route('お知らせ');
    }
}
