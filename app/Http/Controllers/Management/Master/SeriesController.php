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
use Illuminate\Http\Request;

class SeriesController extends AbstractManagementController
{
    /**
     * インデックス
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request): Application|Factory|View
    {
        $serieses = Orm\GameSeries::orderByDesc('id');

        $searchName = trim($request->query('name', ''));
        $search = [];

        if (!empty($searchName)) {
            $search['name'] = $searchName;
            $words = explode(' ', $searchName);

            $serieses->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->orWhere('name', operator: 'LIKE', value: '%' . $word . '%');
                    $query->orWhere('phonetic', operator: 'LIKE', value: '%' . $word . '%');
                }
            });
        }

        $this->putSearchSession('search_series', $search);

        return view('management.master.series.index', [
            'search'   => $search,
            'serieses' => $serieses->paginate(self::ITEMS_PER_PAGE),
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
            'model' => $series
        ]);
    }

    /**
     * 追加画面
     *
     * @return Application|Factory|View
     */
    public function add(): Application|Factory|View
    {
        return view('management.master.series.add', [
            'model'      => new Orm\GameSeries(),
            'franchises' => Orm\GameFranchise::getHashBy('name'),
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
        return view('management.master.series.edit', [
            'model'      => $series,
            'makers'     => Orm\GameMaker::getHashBy('name'),
            'franchises' => Orm\GameFranchise::getHashBy('name'),
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
