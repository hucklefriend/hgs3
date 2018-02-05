<?php
/**
 * パッケージコントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Game\GamePackageRequest;
use Hgs3\Models\Orm;

class PackageController extends Controller
{
    /**
     * 追加画面
     *
     * @param Orm\GameSoft $gameSoft
     * @return $this
     */
    public function add(Orm\GameSoft $gameSoft)
    {
        return view('game.package.add')->with([
            'gameSoft' => $gameSoft
        ]);
    }

    /**
     * 登録
     *
     * @param GamePackageRequest $request
     * @param Orm\GameSoft $gameSoft
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function insert(GamePackageRequest $request, Orm\GameSoft $gameSoft)
    {
        // TODO GamePackageRequestの実装

        $pkg = new Orm\GamePackage;

        $pkg->soft_id = $gameSoft->id;
        $pkg->platform_id = $request->get('platform_id');
        $pkg->company_id = $request->get('company_id');
        $pkg->name = $request->get('name') ?? '';
        $pkg->url = $request->get('url') ?? '';     // TODO: ない時はnullにする
        $pkg->release_at = $request->get('release_at') ?? '';       // TODO: ない時はnullにする
        $pkg->release_int = $request->get('release_int') ?? 0;
        $pkg->game_type_id = $request->get('game_type');

        // ASINを見てamazon情報を取得する

        $pkg->save();

        return redirect('game/soft/' . $game->id);
    }

    /**
     * パッケージ編集画面
     *
     * @param Orm\GameSoft $game
     * @param Orm\GamePackage $pkg
     * @return $this
     */
    public function edit(Orm\GameSoft $game, Orm\GamePackage $pkg)
    {
        return view('game.package.edit')->with([
            'game' => $game,
            'pkg'  => $pkg
        ]);
    }

    /**
     * パッケージ編集
     *
     * @param GamePackageRequest $request
     * @param Orm\GameSoft $gameSoft
     * @param Orm\GamePackage $gamePackage
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(GamePackageRequest $request, Orm\GameSoft $gameSoft, Orm\GamePackage $gamePackage)
    {
        $gamePackage->platform_id = $request->get('platform_id');
        $gamePackage->company_id = $request->get('company_id');
        $gamePackage->name = $request->get('name') ?? '';
        $gamePackage->url = $request->get('url') ?? '';     // TODO: ない時はnullにする
        $gamePackage->release_at = $request->get('release_at') ?? '';       // TODO: ない時はnullにする
        $gamePackage->release_int = $request->get('release_int') ?? 0;
        $gamePackage->game_type_id = $request->get('game_type');

        $gamePackage->save();

        return redirect('game/soft/' . $gameSoft->id);
    }

    /**
     * パッケージ削除
     *
     * @param Orm\GamePackage $gamePackage
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function remove(Orm\GamePackage $gamePackage)
    {
        $gameId = $gamePackage->soft_id;

        $gamePackage->delete();

        return redirect('game/soft/' . $gameId);
    }
}
