<?php
/**
 * [管理]ソフト
 */

namespace Hgs3\Http\Controllers\Management\Master;

use Hgs3\Http\Controllers\AbstractManagementController;
use Hgs3\Http\Requests\Master\GameSoftRequest;
use Hgs3\Models\Orm;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SoftController extends AbstractManagementController
{
    /**
     * インデックス
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $softs = Orm\GameCompany::orderByDesc('id')
            ->paginate(20);

        return view('management.master.soft.index', [
            'softs' => $softs
        ]);
    }


    /**
     * 詳細
     *
     * @param Orm\GameCompany $soft
     * @return Application|Factory|View
     */
    public function detail(Orm\GameCompany $soft): Application|Factory|View
    {
        return view('management.master.soft.detail', [
            'soft' => $soft
        ]);
    }

    /**
     * 追加画面
     *
     * @return Application|Factory|View
     */
    public function add(): Application|Factory|View
    {
        return view('management.master.soft.add');
    }

    /**
     * 追加処理
     *
     * @param GameSoftRequest $request
     * @return RedirectResponse
     */
    public function store(GameSoftRequest $request): RedirectResponse
    {
        $soft = new Orm\GameCompany();
        $soft->fill($request->validated());
        $soft->save();

        return redirect()->route('管理-マスター-ソフト詳細', $soft);
    }

    /**
     * 編集画面
     *
     * @param Orm\GameCompany $soft
     * @return Application|Factory|View
     */
    public function edit(Orm\GameCompany $soft): Application|Factory|View
    {
        return view('management.master.soft.edit', [
            'soft' => $soft
        ]);
    }

    /**
     * データ更新
     *
     * @param GameSoftRequest $request
     * @param Orm\GameCompany $soft
     * @return RedirectResponse
     */
    public function update(GameSoftRequest $request, Orm\GameCompany $soft): RedirectResponse
    {
        $soft->fill($request->validated());
        $soft->save();

        return redirect()->route('管理-マスター-ソフト詳細', $soft);
    }

    /**
     * 削除
     *
     * @param Orm\GameCompany $soft
     * @return RedirectResponse
     */
    public function delete(Orm\GameCompany $soft): RedirectResponse
    {
        $soft->delete();

        return redirect()->route('管理-マスター-ソフト');
    }
}
