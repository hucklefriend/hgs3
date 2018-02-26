<?php
/**
 * システム更新コントローラー
 */

namespace Hgs3\Http\Controllers\System;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\System\UpdateHistoryRequest;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;

class UpdateHistoryController extends Controller
{
    /**
     * 追加画面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('system.updateHistory.add');
    }

    /**
     * データ追加
     *
     * @param UpdateHistoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function insert(UpdateHistoryRequest $request)
    {
        $updateHistory = new Orm\SystemUpdateHistory();
        $updateHistory->title = $request->input('title', '');
        $updateHistory->detail = $request->input('detail', '');
        $updateHistory->update_at = $request->input('update_at', '');

        $updateHistory->save();

        return redirect()->route('システム更新履歴');
    }

    /**
     * 編集画面
     *
     * @param Orm\SystemUpdateHistory $updateHistory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Orm\SystemUpdateHistory $updateHistory)
    {
        return view('system.updateHistory.edit', [
            'updateHistory' => $updateHistory
        ]);
    }

    /**
     * データ更新
     *
     * @param UpdateHistoryRequest $request
     * @param Orm\SystemUpdateHistory $updateHistory
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateHistoryRequest $request, Orm\SystemUpdateHistory $updateHistory)
    {
        $updateHistory->title = $request->input('title', '');
        $updateHistory->detail = $request->input('detail', '');
        $updateHistory->update_at = $request->input('update_at', '');

        $updateHistory->save();

        return redirect()->route('システム更新内容', ['updateHistory' => $updateHistory->id]);
    }

    /**
     * 削除
     *
     * @param Orm\SystemUpdateHistory $updateHistory
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Orm\SystemUpdateHistory $updateHistory)
    {
        $updateHistory->delete();

        return redirect()->back();
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $histories = Orm\SystemUpdateHistory::select(array('id', 'title', DB::raw('UNIX_TIMESTAMP(update_at) AS update_at_ts')))
            ->where('update_at', '<=', DB::raw('NOW()'))
            ->orderBy('update_at', 'DESC')
            ->paginate(30);

        return view('system.updateHistory.index', [
            'histories' => $histories
        ]);
    }

    /**
     * 詳細
     *
     * @param Orm\SystemUpdateHistory $updateHistory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Orm\SystemUpdateHistory $updateHistory)
    {
        $updateHistory->update_at = date('Y/m/d H:i', strtotime($updateHistory->update_at));

        return view('system.updateHistory.detail', [
            'updateHistory' => $updateHistory
        ]);
    }
}
