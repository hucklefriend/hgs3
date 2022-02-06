<?php
/**
 * [管理]メーカー
 */

namespace Hgs3\Http\Controllers\Management\Master;

use Hgs3\Http\Controllers\AbstractManagementController;
use Hgs3\Http\Requests\Master\GameMakerRequest;
use Hgs3\Models\Orm;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MakerController extends AbstractManagementController
{
    /**
     * インデックス
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request): Application|Factory|View
    {
        $makers = Orm\GameMaker::orderByDesc('id');

        $searchName = trim($request->query('name', ''));
        $search = [];

        if (!empty($searchName)) {
            $search['name'] = $searchName;
            $words = explode(' ', $searchName);

            $makers->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->orWhere('name', operator: 'LIKE', value: '%' . $word . '%');
                    $query->orWhere('phonetic', operator: 'LIKE', value: '%' . $word . '%');
                    $query->orWhere('acronym', operator: 'LIKE', value: '%' . $word . '%');
                }
            });
        }

        $this->putSearchSession('search_maker', $search);

        return view('management.master.maker.index', [
            'search' => $search,
            'makers' => $makers->paginate(self::ITEMS_PER_PAGE)
        ]);
    }

    /**
     * 詳細
     *
     * @param Orm\GameMaker $maker
     * @return Application|Factory|View
     */
    public function detail(Orm\GameMaker $maker): Application|Factory|View
    {
        return view('management.master.maker.detail', [
            'model' => $maker
        ]);
    }

    /**
     * 追加画面
     *
     * @return Application|Factory|View
     */
    public function add(): Application|Factory|View
    {
        return view('management.master.maker.add', [
            'model' => new Orm\GameMaker(),
        ]);
    }

    /**
     * 追加処理
     *
     * @param GameMakerRequest $request
     * @return RedirectResponse
     */
    public function store(GameMakerRequest $request): RedirectResponse
    {
        $maker = new Orm\GameMaker();
        $maker->fill($request->validated());
        $maker->save();

        return redirect()->route('管理-マスター-メーカー詳細', $maker);
    }

    /**
     * 編集画面
     *
     * @param Orm\GameMaker $maker
     * @return Application|Factory|View
     */
    public function edit(Orm\GameMaker $maker): Application|Factory|View
    {
        return view('management.master.maker.edit', [
            'model' => $maker
        ]);
    }

    /**
     * データ更新
     *
     * @param GameMakerRequest $request
     * @param Orm\GameMaker $maker
     * @return RedirectResponse
     */
    public function update(GameMakerRequest $request, Orm\GameMaker $maker): RedirectResponse
    {
        $maker->fill($request->validated());
        $maker->save();

        return redirect()->route('管理-マスター-メーカー詳細', $maker);
    }

    /**
     * 削除
     *
     * @param Orm\GameMaker $maker
     * @return RedirectResponse
     */
    public function delete(Orm\GameMaker $maker): RedirectResponse
    {
        $maker->delete();

        return redirect()->route('管理-マスター-メーカー');
    }
}
