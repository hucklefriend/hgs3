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

class MakerController extends AbstractManagementController
{
    /**
     * インデックス
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $makers = Orm\GameCompany::orderByDesc('id')
            ->paginate(20);

        return view('management.master.maker.index', [
            'makers' => $makers
        ]);
    }


    /**
     * 詳細
     *
     * @param Orm\GameCompany $maker
     * @return Application|Factory|View
     */
    public function detail(Orm\GameCompany $maker): Application|Factory|View
    {
        return view('management.master.maker.detail', [
            'maker' => $maker
        ]);
    }

    /**
     * 追加画面
     *
     * @return Application|Factory|View
     */
    public function add(): Application|Factory|View
    {
        return view('management.master.maker.add');
    }

    /**
     * 追加処理
     *
     * @param GameMakerRequest $request
     * @return RedirectResponse
     */
    public function store(GameMakerRequest $request): RedirectResponse
    {
        $maker = new Orm\GameCompany();
        $maker->fill($request->validated());
        $maker->save();

        return redirect()->route('管理-マスター-メーカー詳細', $maker);
    }

    /**
     * 編集画面
     *
     * @param Orm\GameCompany $maker
     * @return Application|Factory|View
     */
    public function edit(Orm\GameCompany $maker): Application|Factory|View
    {
        return view('management.master.maker.edit', [
            'maker' => $maker
        ]);
    }

    /**
     * データ更新
     *
     * @param GameMakerRequest $request
     * @param Orm\GameCompany $maker
     * @return RedirectResponse
     */
    public function update(GameMakerRequest $request, Orm\GameCompany $maker): RedirectResponse
    {
        $maker->fill($request->validated());
        $maker->save();

        return redirect()->route('管理-マスター-メーカー詳細', $maker);
    }

    /**
     * 削除
     *
     * @param Orm\GameCompany $maker
     * @return RedirectResponse
     */
    public function delete(Orm\GameCompany $maker): RedirectResponse
    {
        $maker->delete();

        return redirect()->route('管理-マスター-メーカー');
    }
}
