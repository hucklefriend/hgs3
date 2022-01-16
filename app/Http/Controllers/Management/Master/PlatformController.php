<?php
/**
 * [管理]プラットフォーム
 */

namespace Hgs3\Http\Controllers\Management\Master;

use Hgs3\Http\Controllers\AbstractManagementController;
use Hgs3\Http\Requests\Master\GamePlatformRequest;
use Hgs3\Models\Orm;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PlatformController extends AbstractManagementController
{
    /**
     * インデックス
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $platforms = Orm\GamePlatform::orderByDesc('id')
            ->paginate(20);

        return view('management.master.platform.index', [
            'platforms' => $platforms
        ]);
    }


    /**
     * 詳細
     *
     * @param Orm\GamePlatform $platform
     * @return Application|Factory|View
     */
    public function detail(Orm\GamePlatform $platform): Application|Factory|View
    {
        return view('management.master.platform.detail', [
            'platform' => $platform
        ]);
    }

    /**
     * 追加画面
     *
     * @return Application|Factory|View
     */
    public function add(): Application|Factory|View
    {
        return view('management.master.platform.add');
    }

    /**
     * 追加処理
     *
     * @param GamePlatformRequest $request
     * @return RedirectResponse
     */
    public function store(GamePlatformRequest $request): RedirectResponse
    {
        $platform = new Orm\GamePlatform();
        $platform->fill($request->validated());
        $platform->save();

        return redirect()->route('管理-マスター-プラットフォーム詳細', $platform);
    }

    /**
     * 編集画面
     *
     * @param Orm\GamePlatform $platform
     * @return Application|Factory|View
     */
    public function edit(Orm\GamePlatform $platform): Application|Factory|View
    {
        return view('management.master.platform.edit', [
            'platform' => $platform
        ]);
    }

    /**
     * データ更新
     *
     * @param GamePlatformRequest $request
     * @param Orm\GamePlatform $platform
     * @return RedirectResponse
     */
    public function update(GamePlatformRequest $request, Orm\GamePlatform $platform): RedirectResponse
    {
        $platform->fill($request->validated());
        $platform->save();

        return redirect()->route('管理-マスター-プラットフォーム詳細', $platform);
    }

    /**
     * 削除
     *
     * @param Orm\GamePlatform $platform
     * @return RedirectResponse
     */
    public function delete(Orm\GamePlatform $platform): RedirectResponse
    {
        $platform->delete();

        return redirect()->route('管理-マスター-プラットフォーム');
    }
}
