<?php
/**
 * パッケージコントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Game\GamePackageRequest;
use Hgs3\Models\Game\Package;
use Hgs3\Models\Orm;

class PackageController extends Controller
{
    /**
     * 追加画面
     *
     * @param Orm\GameSoft $soft
     * @return $this
     */
    public function add(Orm\GameSoft $soft)
    {
        return view('game.package.add')->with([
            'soft' => $soft
        ]);
    }

    /**
     * 登録
     *
     * @param GamePackageRequest $request
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function insert(GamePackageRequest $request, Orm\GameSoft $soft)
    {
        $pkg = new Orm\GamePackage;

        $pkg->platform_id = $request->get('platform_id');
        $pkg->company_id = $request->get('company_id');
        $pkg->name = $request->get('name', '');
        $pkg->url = $request->get('url');
        $pkg->release_at = $request->get('release_at', '');
        $pkg->release_int = $request->get('release_int', 99999999);

        Package::insert($soft, $pkg, $request->get('asin'));

        return redirect()->route('ゲーム詳細', ['soft' => $soft]);
    }

    /**
     * パッケージ編集画面
     *
     * @param Orm\GameSoft $soft
     * @param Orm\GamePackage $package
     * @return $this
     */
    public function edit(Orm\GameSoft $soft, Orm\GamePackage $package)
    {
        // TODO ソフトとパッケージの紐づけチェック

        $package->setShop();

        return view('game.package.edit', [
            'soft'    => $soft,
            'package' => $package
        ]);
    }

    /**
     * パッケージ編集
     *
     * @param GamePackageRequest $request
     * @param Orm\GameSoft $soft
     * @param Orm\GamePackage $package
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(GamePackageRequest $request, Orm\GameSoft $soft, Orm\GamePackage $package)
    {
        // TODO ソフトとパッケージの紐づけチェック

        $package->platform_id = $request->get('platform_id');
        $package->company_id = $request->get('company_id');
        $package->name = $request->get('name', '');
        $package->url = $request->get('url');
        $package->release_at = $request->get('release_at');
        $package->release_int = $request->get('release_int', 99999999);

        Package::update($soft, $package, $request->get('asin'));

        return redirect()->route('ゲーム詳細', ['soft' => $soft->id]);
    }

    /**
     * パッケージ削除
     *
     * @param Orm\GameSoft $soft
     * @param Orm\GamePackage $package
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Orm\GameSoft $soft, Orm\GamePackage $package)
    {
        // TODO ソフトとパッケージの紐づけチェック

        Package::delete($soft, $package);
        return redirect()->route('ゲーム詳細', ['soft' => $soft->id]);
    }
}
