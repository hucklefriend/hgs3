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
        $softs = Orm\GameSoft::orderByDesc('id')
            ->paginate(20);

        return view('management.master.soft.index', [
            'softs' => $softs
        ]);
    }


    /**
     * 詳細
     *
     * @param Orm\GameSoft $soft
     * @return Application|Factory|View
     */
    public function detail(Orm\GameSoft $soft): Application|Factory|View
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
        $franchises = Orm\GameFranchise::getNameHash();
        $series = Orm\GameSeries::getNameHash(['' => '']);
        $series2Franchise = Orm\GameSeries::getFranchiseHash();

        return view('management.master.soft.add', [
            'franchises' => $franchises,
            'series' => $series,
            'series2Franchise' => $series2Franchise
        ]);
    }

    /**
     * 追加処理
     *
     * @param GameSoftRequest $request
     * @return RedirectResponse
     */
    public function store(GameSoftRequest $request): RedirectResponse
    {
        $soft = new Orm\GameSoft();
        $soft->fill($request->validated());
        $soft->save();

        return redirect()->route('管理-マスター-ソフト詳細', $soft);
    }

    /**
     * 編集画面
     *
     * @param Orm\GameSoft $soft
     * @return Application|Factory|View
     */
    public function edit(Orm\GameSoft $soft): Application|Factory|View
    {
        $franchises = Orm\GameFranchise::getNameHash();
        $series = Orm\GameSeries::getNameHash(['' => '']);
        $series2Franchise = Orm\GameSeries::getFranchiseHash();

        return view('management.master.soft.edit', [
            'soft' => $soft,
            'franchises' => $franchises,
            'series' => $series,
            'series2Franchise' => $series2Franchise
        ]);
    }

    /**
     * データ更新
     *
     * @param GameSoftRequest $request
     * @param Orm\GameSoft $soft
     * @return RedirectResponse
     */
    public function update(GameSoftRequest $request, Orm\GameSoft $soft): RedirectResponse
    {
        $soft->fill($request->validated());
        $soft->save();

        return redirect()->route('管理-マスター-ソフト詳細', $soft);
    }

    /**
     * 削除
     *
     * @param Orm\GameSoft $soft
     * @return RedirectResponse
     */
    public function delete(Orm\GameSoft $soft): RedirectResponse
    {
        $soft->delete();

        return redirect()->route('管理-マスター-ソフト');
    }
}
