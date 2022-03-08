<?php
/**
 * [管理]パッケージ
 */

namespace Hgs3\Http\Controllers\Management\Master;

use Hgs3\Enums\Game\Shop;
use Hgs3\Enums\RatedR;
use Hgs3\Http\Controllers\AbstractManagementController;
use Hgs3\Http\Requests\Master\GamePackageHardRelationRequest;
use Hgs3\Http\Requests\Master\GamePackageRequest;
use Hgs3\Http\Requests\Master\GamePackageShopRequest;
use Hgs3\Http\Requests\Master\GamePackageSoftRelationRequest;
use Hgs3\Log;
use Hgs3\Models\Orm;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PackageController extends AbstractManagementController
{
    /**
     * インデックス
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request): Application|Factory|View
    {
        $packages = Orm\GamePackage::orderByDesc('id');

        $searchName = trim($request->query('name', ''));
        $searchPlatform = $request->query('platform');
        $searchHard = $request->query('hard');
        $search = [];

        if (!empty($searchName)) {
            $search['name'] = $searchName;
            $words = explode(' ', $searchName);

            $packages->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->orWhere('name', 'LIKE', '%' . $word . '%');
                }
            });
        }

        if (!empty($searchPlatform)) {
            $search['platform'] = $searchPlatform;
            $packages->where('platform_id', '=', $searchPlatform);
        }

        if (!empty($searchHard)) {
            $search['hard'] = $searchHard;
            $packages->whereHas('hards', function (Builder $query) use($searchHard) {
                $query->where('game_hard_id', '=', $searchHard);
            });
        }

        $this->putSearchSession('search_package', $search);

        return view('management.master.package.index', [
            'packages'  => $packages->paginate(self::ITEMS_PER_PAGE),
            'search'    => $search,
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
        return view('management.master.package.detail', ['package' => $package]);
    }

    /**
     * 追加画面
     *
     * @return Application|Factory|View
     */
    public function add(): Application|Factory|View
    {
        return view('management.master.package.add', ['model' => new Orm\GamePackage()]);
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
        return view('management.master.package.edit', ['model' => $package]);
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
     * 複製画面
     *
     * @param Orm\GamePackage $package
     * @return Application|Factory|View
     */
    public function copy(Orm\GamePackage $package): Application|Factory|View
    {
        $formData = self::getFormData();
        $formData['model'] = $package;

        return view('management.master.package.copy', $formData);
    }

    /**
     * データ複製
     *
     * @param GamePackageRequest $request
     * @param Orm\GamePackage $package
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function doCopy(GamePackageRequest $request, Orm\GamePackage $package): RedirectResponse
    {
        $dest = new Orm\GamePackage();
        $dest->fill($request->validated());
        $dest->saveWithSoftRelation($package->softs()->get(['id'])->pluck('id')->toArray());

        return redirect()->route('管理-マスター-パッケージ詳細', $dest);
    }

    /**
     * ハード紐づけ画面
     *
     * @param Orm\GamePackage $package
     * @return Application|Factory|View
     */
    public function relateHard(Orm\GamePackage $package): Application|Factory|View
    {
        return view('management.master.package.relate_hard', [
            'package'      => $package,
            'relatedHards' => $package->hards()->get(['id'])->pluck('id', 'id'),
            'hards'        => Orm\GameHard::all()
        ]);
    }

    /**
     * ハード紐づけ
     *
     * @param GamePackageHardRelationRequest $request
     * @param Orm\GamePackage $package
     * @return RedirectResponse
     */
    public function doRelateHard(GamePackageHardRelationRequest $request, Orm\GamePackage $package): RedirectResponse
    {
        $package->hards()->sync($request->input('hard_id'));

        return redirect()->route('管理-マスター-パッケージ詳細', $package);
    }

    /**
     * ソフト紐づけ画面
     *
     * @param Orm\GamePackage $package
     * @return Application|Factory|View
     */
    public function relateSoft(Orm\GamePackage $package): Application|Factory|View
    {
        return view('management.master.package.relate_soft', [
            'package'      => $package,
            'relatedSofts' => $package->softs()->get(['id'])->pluck('id', 'id'),
            'softs'        => Orm\GameSoft::all()
        ]);
    }

    /**
     * ソフト紐づけ
     *
     * @param GamePackageSoftRelationRequest $request
     * @param Orm\GamePackage $package
     * @return RedirectResponse
     */
    public function doRelateSoft(GamePackageSoftRelationRequest $request, Orm\GamePackage $package): RedirectResponse
    {
        $package->softs()->sync($request->input('soft_id'));

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

    /**
     * ショップ詳細
     *
     * @param Orm\GamePackage $package
     * @param Orm\GamePackageShop $shop
     * @return Application|Factory|View
     */
    public function shopDetail(Orm\GamePackage $package, Orm\GamePackageShop $shop): Application|Factory|View
    {
        return view('management.master.package.shop_detail', [
            'package' => $package,
            'shop'    => $shop,
        ]);
    }

    /**
     * ショップ追加
     *
     * @param Orm\GamePackage $package
     * @return Application|Factory|View
     */
    public function shopAdd(Orm\GamePackage $package): Application|Factory|View
    {
        $model = new Orm\GamePackageShop;
        $model->release_int = $package->release_int;

        return view('management.master.package.shop_add', [
            'model'   => $model,
            'package' => $package,
        ]);
    }

    /**
     * 追加処理
     *
     * @param GamePackageShopRequest $request
     * @param Orm\GamePackage $package
     * @return RedirectResponse
     */
    public function shopStore(GamePackageShopRequest $request, Orm\GamePackage $package): RedirectResponse
    {
        $shop = new Orm\GamePackageShop();
        $shop->fill($request->validated());
        $shop->package_id = $package->id;
        $shop->save();

        return redirect()->route('管理-マスター-パッケージ詳細', $package);
    }

    /**
     * ショップ編集
     *
     * @param Orm\GamePackage $package
     * @param Orm\GamePackageShop $shop
     * @return Application|Factory|View
     */
    public function shopEdit(Orm\GamePackage $package, Orm\GamePackageShop $shop): Application|Factory|View
    {
        return view('management.master.package.shop_edit', [
            'model'   => $shop,
            'package' => $package,
        ]);
    }

    /**
     * データ更新
     *
     * @param GamePackageShopRequest $request
     * @param Orm\GamePackage $package
     * @param Orm\GamePackageShop $shop
     * @return RedirectResponse
     */
    public function shopUpdate(GamePackageShopRequest $request, Orm\GamePackage $package, Orm\GamePackageShop $shop): RedirectResponse
    {
        $shop->fill($request->validated());
        $shop->save();

        return redirect()->route('管理-マスター-パッケージ詳細', $package);
    }

    /**
     * 削除
     *
     * @param Orm\GamePackage $package
     * @param Orm\GamePackageShop $shop
     * @return RedirectResponse
     */
    public function shopDelete(Orm\GamePackage $package, Orm\GamePackageShop $shop): RedirectResponse
    {
        $shop->delete();

        return redirect()->route('管理-マスター-パッケージ詳細', $package);
    }
}
