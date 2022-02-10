<?php
/**
 * [管理]フランチャイズ
 */

namespace Hgs3\Http\Controllers\Management\Master;

use Hgs3\Http\Controllers\AbstractManagementController;
use Hgs3\Http\Requests\Master\GameFranchiseRequest;
use Hgs3\Models\Orm;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FranchiseController extends AbstractManagementController
{
    /**
     * インデックス
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request): Application|Factory|View
    {
        $franchises = Orm\GameFranchise::orderByDesc('id');

        $searchName = trim($request->query('name', ''));
        $search = [];

        if (!empty($searchName)) {
            $search['name'] = $searchName;
            $words = explode(' ', $searchName);

            $franchises->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->orWhere('name', operator: 'LIKE', value: '%' . $word . '%');
                    $query->orWhere('phonetic', operator: 'LIKE', value: '%' . $word . '%');
                }
            });
        }

        $this->putSearchSession('search_franchise', $search);

        return view('management.master.franchise.index', [
            'franchises' => $franchises->paginate(self::ITEMS_PER_PAGE),
            'search'     => $search
        ]);
    }

    /**
     * 詳細
     *
     * @param Orm\GameFranchise $franchise
     * @return Application|Factory|View
     */
    public function detail(Orm\GameFranchise $franchise): Application|Factory|View
    {
        return view('management.master.franchise.detail', [
            'model' => $franchise
        ]);
    }

    /**
     * 追加画面
     *
     * @return Application|Factory|View
     */
    public function add(): Application|Factory|View
    {
        return view('management.master.franchise.add', [
            'model' => new Orm\GameFranchise(),
        ]);
    }

    /**
     * 追加処理
     *
     * @param GameFranchiseRequest $request
     * @return RedirectResponse
     */
    public function store(GameFranchiseRequest $request): RedirectResponse
    {
        $franchise = new Orm\GameFranchise();
        $franchise->fill($request->validated());
        $franchise->save();

        return redirect()->route('管理-マスター-フランチャイズ詳細', $franchise);
    }

    /**
     * 編集画面
     *
     * @param Orm\GameFranchise $franchise
     * @return Application|Factory|View
     */
    public function edit(Orm\GameFranchise $franchise): Application|Factory|View
    {
        return view('management.master.franchise.edit', [
            'model' => $franchise
        ]);
    }

    /**
     * データ更新
     *
     * @param GameFranchiseRequest $request
     * @param Orm\GameFranchise $franchise
     * @return RedirectResponse
     */
    public function update(GameFranchiseRequest $request, Orm\GameFranchise $franchise): RedirectResponse
    {
        $franchise->fill($request->validated());
        $franchise->save();

        return redirect()->route('管理-マスター-フランチャイズ詳細', $franchise);
    }

    /**
     * 削除
     *
     * @param Orm\GameFranchise $franchise
     * @return RedirectResponse
     */
    public function delete(Orm\GameFranchise $franchise): RedirectResponse
    {
        $franchise->delete();

        return redirect()->route('管理-マスター-フランチャイズ');
    }
}
