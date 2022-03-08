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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SoftController extends AbstractManagementController
{
    /**
     * インデックス
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request): Application|Factory|View
    {
        $softs = Orm\GameSoft::orderByDesc('id');

        $searchName = trim($request->query('name', ''));
        $searchFranchise = $request->query('franchise');
        $searchSeries = $request->query('series');
        $search = [];

        if (!empty($searchName)) {
            $search['name'] = $searchName;
            $words = explode(' ', $searchName);

            $softs->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->orWhere('name', operator: 'LIKE', value: '%' . $word . '%');
                    $query->orWhere('phonetic', operator: 'LIKE', value: '%' . $word . '%');
                }
            });
        }

        if ($searchFranchise !== null) {
            $search['franchise'] = $searchFranchise;
            $softs->where('franchise_id', '=', $searchFranchise);
        }

        if ($searchSeries !== null) {
            $search['series'] = $searchSeries;
            $softs->where('series_id', '=',  $searchSeries);
        }

        $this->putSearchSession('search_soft', $search);

        return view('management.master.soft.index', [
            'search'     => $search,
            'franchises' => Orm\GameFranchise::getHashBy('name', prepend: ['' => ' ']),
            'series'     => Orm\GameSeries::getHashBy('name', prepend: ['' => ' ']),
            'softs'      => $softs->paginate(self::ITEMS_PER_PAGE)
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
            'model' => $soft
        ]);
    }

    /**
     * 追加画面
     *
     * @return Application|Factory|View
     */
    public function add(): Application|Factory|View
    {
        return view('management.master.soft.add', [
            'model'            => new Orm\GameSoft(),
            'franchises'       => Orm\GameFranchise::gethashBy('name'),
            'series'           => Orm\GameSeries::gethashBy('name', prepend: ['' => '']),
            'series2Franchise' => Orm\GameSeries::gethashBy('franchise_id'),
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
        Orm\GameSoft::updatePhoneticOrder();

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
        return view('management.master.soft.edit', [
            'model'            => $soft,
            'franchises'       => Orm\GameFranchise::gethashBy('name'),
            'series'           => Orm\GameSeries::gethashBy('name', prepend: ['' => '']),
            'series2Franchise' => Orm\GameSeries::gethashBy('franchise_id'),
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
        Orm\GameSoft::updatePhoneticOrder();

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
