<?php
/**
 * プラットフォームコントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Http\Requests\Game\GamePlatformRequest;
use Hgs3\Models\Orm;
use Hgs3\Http\Controllers\Controller;

class PlatformController extends Controller
{
    /**
     * プラットフォーム一覧
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $platforms = Orm\GamePlatform::orderBy('sort_order')->get();

        return view('game.platform.index', [
            'platforms' => $platforms
        ]);
    }

    /**
     * プラットフォーム詳細
     *
     * @param Orm\GamePlatform $platform
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Orm\GamePlatform $platform)
    {
        $data = $platform->getSoft();

        return view('game.platform.detail', [
            'platform' => $platform,
            'company'  => Orm\GameCompany::find($platform->company_id),
            'soft'     => $data['soft'],
            'packages' => $data['packages']
        ]);
    }

    /**
     * データ登録
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('game.platform.add');
    }

    /**
     * データ追加
     *
     * @param GamePlatformRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function insert(GamePlatformRequest $request)
    {
        $platform = new Orm\GamePlatform;
        $platform->company_id = intval($request->input('company_id', 0));
        $platform->name = $request->input('name', '');
        $platform->acronym = $request->input('acronym', '');
        $platform->sort_order = intval($request->input('sort_order'));
        $platform->wikipedia = $request->input('wikipedia');

        $platform->save();

        return redirect('game/platform');
    }

    /**
     * データ編集
     *
     * @param Orm\GamePlatform $platform
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Orm\GamePlatform $platform)
    {
        return view('game.platform.edit', [
            'platform' => $platform
        ]);
    }

    /**
     * データ更新
     *
     * @param GamePlatformRequest $request
     * @param Orm\GamePlatform $platform
     * @return PlatformController
     */
    public function update(GamePlatformRequest $request, Orm\GamePlatform $platform)
    {
        $platform->company_id = intval($request->input('company_id', 0));
        $platform->name = $request->input('name', '');
        $platform->acronym = $request->input('acronym', '');
        $platform->sort_order = intval($request->input('sort_order'));
        $platform->wikipedia = $request->input('wikipedia');

        $platform->save();

        return redirect('game/platform/' . $platform->id);
    }
}
