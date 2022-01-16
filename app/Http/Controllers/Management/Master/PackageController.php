<?php
/**
 * [管理]パッケージ
 */

namespace Hgs3\Http\Controllers\Management\Master;

use Hgs3\Http\Controllers\AbstractManagementController;
use Hgs3\Http\Requests\Master\GamePackageRequest;
use Hgs3\Models\Orm;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PackageController extends AbstractManagementController
{
    /**
     * インデックス
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $packages = Orm\GamePackage::orderByDesc('id')
            ->paginate(20);

        return view('management.master.package.index', [
            'packages' => $packages
        ]);
    }


    /**
     * 詳細
     *
     * @param Orm\GamePackage $package
     * @return Application|Factory|View
     */
    public function detail(Orm\GamePackage $package): Application|Factory|View
    {
        return view('management.master.package.detail', [
            'package' => $package
        ]);
    }

    /**
     * 追加画面
     *
     * @return Application|Factory|View
     */
    public function add(): Application|Factory|View
    {
        return view('management.master.package.add');
    }

    /**
     * 追加処理
     *
     * @param GamePackageRequest $request
     * @return RedirectResponse
     */
    public function store(GamePackageRequest $request): RedirectResponse
    {
        $package = new Orm\GamePackage();
        $package->fill($request->validated());
        $package->save();

        return redirect()->route('管理-マスター-パッケージ詳細', $package);
    }

    /**
     * 編集画面
     *
     * @param Orm\GamePackage $package
     * @return Application|Factory|View
     */
    public function edit(Orm\GamePackage $package): Application|Factory|View
    {
        return view('management.master.package.edit', [
            'package' => $package
        ]);
    }

    /**
     * データ更新
     *
     * @param GamePackageRequest $request
     * @param Orm\GamePackage $package
     * @return RedirectResponse
     */
    public function update(GamePackageRequest $request, Orm\GamePackage $package): RedirectResponse
    {
        $package->fill($request->validated());
        $package->save();

        return redirect()->route('管理-マスター-パッケージ詳細', $package);
    }

    /**
     * 削除
     *
     * @param Orm\GamePackage $package
     * @return RedirectResponse
     */
    public function delete(Orm\GamePackage $package): RedirectResponse
    {
        $package->delete();

        return redirect()->route('管理-マスター-パッケージ');
    }
}
