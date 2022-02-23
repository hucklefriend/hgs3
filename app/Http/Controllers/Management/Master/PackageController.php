<?php
/**
 * [管理]パッケージ
 */

namespace Hgs3\Http\Controllers\Management\Master;

use Hgs3\Enums\Game\Shop;
use Hgs3\Enums\RatedR;
use Hgs3\Http\Controllers\AbstractManagementController;
use Hgs3\Http\Requests\Master\GamePackageRequest;
use Hgs3\Http\Requests\Master\GamePackageShopRequest;
use Hgs3\Models\Orm;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
                    $query->orWhere('name', operator: 'LIKE', value: '%' . $word . '%');
                }
            });
        }

        if (!empty($searchPlatform)) {
            $search['platform'] = $searchPlatform;
            $packages->where('platform_id', value: $searchPlatform);
        }

        if (!empty($searchHard)) {
            $search['hard'] = $searchHard;
            $packages->where('hard_id', value: $searchHard);
        }

        $this->putSearchSession('search_package', $search);

        return view('management.master.package.index', [
            'packages'  => $packages->paginate(self::ITEMS_PER_PAGE),
            'hards'     => Orm\GameHard::getHashBy('acronym', prepend: ['' => ' ']),
            'platforms' => Orm\GamePlatform::getHashBy('name', prepend: ['' => ' ']),
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
        $makers = Orm\GameMaker::getHashBy('name');
        $hards = Orm\GameHard::getHashBy('acronym');
        $platforms = Orm\GamePlatform::getHashBy('name', prepend: ['' => '-']);
        $softs = Orm\GameSoft::getHashBy('name', prepend: ['' => '']);

        return view('management.master.package.add', [
            'model'     => new Orm\GamePackage(),
            'makers'    => $makers,
            'hards'     => $hards,
            'platforms' => $platforms,
            'ratedR'    => RatedR::selectList(),
            'softs'     => $softs
        ]);
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
        $makers = Orm\GameMaker::getHashBy('name');
        $hards = Orm\GameHard::getHashBy('acronym');
        $platforms = Orm\GamePlatform::getHashBy('name', prepend: ['' => '-']);
        $softs = Orm\GameSoft::getHashBy('name', prepend: ['' => '']);

        return view('management.master.package.edit', [
            'model'     => $package,
            'makers'    => $makers,
            'hards'     => $hards,
            'platforms' => $platforms,
            'ratedR'    => RatedR::selectList(),
            'softs'     => $softs
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
        return view('management.master.package.shop_add', [
            'model'   => new Orm\GamePackageShop,
            'package' => $package,
            'shops'   => Shop::selectList(),
            'ratedR'  => RatedR::selectList(),
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
            'shops'   => Shop::selectList(),
            'ratedR'  => RatedR::selectList(),
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
