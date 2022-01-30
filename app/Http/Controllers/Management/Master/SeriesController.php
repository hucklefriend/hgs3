<?php
/**
 * [管理]シリーズ
 */

namespace Hgs3\Http\Controllers\Management\Master;

use Hgs3\Http\Controllers\AbstractManagementController;
use Hgs3\Http\Requests\Master\GameSeriesRequest;
use Hgs3\Models\Orm;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SeriesController extends AbstractManagementController
{
    /**
     * インデックス
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $serieses = Orm\GameSeries::orderByDesc('id')
            ->paginate(20);

        return view('management.master.series.index', [
            'serieses' => $serieses
        ]);
    }

    /**
     * 詳細
     *
     * @param Orm\GameSeries $series
     * @return Application|Factory|View
     */
    public function detail(Orm\GameSeries $series): Application|Factory|View
    {
        return view('management.master.series.detail', [
            'series' => $series
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

        return view('management.master.series.add', [
            'franchises' => $franchises,
        ]);
    }

    /**
     * 追加処理
     *
     * @param GameSeriesRequest $request
     * @return RedirectResponse
     */
    public function store(GameSeriesRequest $request): RedirectResponse
    {
        $series = new Orm\GameSeries();
        $series->fill($request->validated());
        $series->save();

        return redirect()->route('管理-マスター-シリーズ詳細', $series);
    }

    /**
     * 編集画面
     *
     * @param Orm\GameSeries $series
     * @return Application|Factory|View
     */
    public function edit(Orm\GameSeries $series): Application|Factory|View
    {
        $makers = Orm\GameCompany::getNameHash();
        $franchises = Orm\GameFranchise::getNameHash();

        return view('management.master.series.edit', [
            'series'     => $series,
            'makers'     => $makers,
            'franchises' => $franchises,
        ]);
    }

    /**
     * データ更新
     *
     * @param GameSeriesRequest $request
     * @param Orm\GameSeries $series
     * @return RedirectResponse
     */
    public function update(GameSeriesRequest $request, Orm\GameSeries $series): RedirectResponse
    {
        $series->fill($request->validated());
        $series->save();

        return redirect()->route('管理-マスター-シリーズ詳細', $series);
    }

    /**
     * 削除
     *
     * @param Orm\GameSeries $series
     * @return RedirectResponse
     */
    public function delete(Orm\GameSeries $series): RedirectResponse
    {
        if ($series->softs()->count() == 0) {
            $series->delete();
        }

        return redirect()->route('管理-マスター-シリーズ');
    }
}
