<?php
/**
 * [管理]ハード
 */

namespace Hgs3\Http\Controllers\Management\Master;

use Hgs3\Http\Controllers\AbstractManagementController;
use Hgs3\Http\Requests\Master\GameHardRequest;
use Hgs3\Models\Orm;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class HardController extends AbstractManagementController
{
    /**
     * インデックス
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $hards = Orm\GameHard::orderByDesc('id')
            ->paginate(self::ITEMS_PER_PAGE);

        return view('management.master.hard.index', [
            'hards' => $hards
        ]);
    }


    /**
     * 詳細
     *
     * @param Orm\GameHard $hard
     * @return Application|Factory|View
     */
    public function detail(Orm\GameHard $hard): Application|Factory|View
    {
        return view('management.master.hard.detail', [
            'hard' => $hard
        ]);
    }

    /**
     * 追加画面
     *
     * @return Application|Factory|View
     */
    public function add(): Application|Factory|View
    {
        return view('management.master.hard.add', [
            'model' => new Orm\GameHard(),
        ]);
    }

    /**
     * 追加処理
     *
     * @param GameHardRequest $request
     * @return RedirectResponse
     */
    public function store(GameHardRequest $request): RedirectResponse
    {
        $hard = new Orm\GameHard();
        $hard->fill($request->validated());
        $hard->save();

        return redirect()->route('管理-マスター-ハード詳細', $hard);
    }

    /**
     * 編集画面
     *
     * @param Orm\GameHard $hard
     * @return Application|Factory|View
     */
    public function edit(Orm\GameHard $hard): Application|Factory|View
    {
        return view('management.master.hard.edit', [
            'model' => $hard
        ]);
    }

    /**
     * データ更新
     *
     * @param GameHardRequest $request
     * @param Orm\GameHard $hard
     * @return RedirectResponse
     */
    public function update(GameHardRequest $request, Orm\GameHard $hard): RedirectResponse
    {
        $hard->fill($request->validated());
        $hard->save();

        return redirect()->route('管理-マスター-ハード詳細', $hard);
    }

    /**
     * 削除
     *
     * @param Orm\GameHard $hard
     * @return RedirectResponse
     */
    public function delete(Orm\GameHard $hard): RedirectResponse
    {
        $hard->delete();

        return redirect()->route('管理-マスター-ハード');
    }
}
