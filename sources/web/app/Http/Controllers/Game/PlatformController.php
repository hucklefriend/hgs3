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
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'game');
    }

    /**
     * プラットフォーム一覧
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $platforms = Orm\GamePlatform::orderBy('sort_order')->get();

        return view('game.platform.list', [
            'platforms' => $platforms
        ]);
    }

    /**
     * プラットフォーム詳細
     *
     * @param Orm\GamePlatform $gamePlatform
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Orm\GamePlatform $gamePlatform)
    {
        $packages = $gamePlatform->getPackages();
        $companies = Orm\GameCompany::getNameHash(array_pluck($packages->items(), 'company_id'));

        return view('game.platform.detail', [
            'gamePlatform' => $gamePlatform,
            'gameCompany'  => Orm\GameCompany::find($gamePlatform->company_id),
            'packages'     => $packages,
            'companies'    => $companies
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
        $gamePlatform = new Orm\GamePlatform;
        $gamePlatform->company_id = intval($request->input('company_id', 0));
        $gamePlatform->name = $request->input('name', '');
        $gamePlatform->acronym = $request->input('acronym', '');
        $gamePlatform->sort_order = intval($request->input('sort_order'));
        $gamePlatform->wikipedia = $request->input('wikipedia');

        $gamePlatform->save();

        return redirect('game/platform');
    }

    /**
     * データ編集
     *
     * @param GamePlatform $gamePlatform
     * @return $this
     */
    public function edit(GamePlatform $gamePlatform)
    {
        return view('game.platform.edit')->with([
            'gamePlatform' => $gamePlatform
        ]);
    }

    /**
     * データ更新
     *
     * @param GamePlatformRequest $request
     * @param GamePlatform $gamePlatform
     * @return PlatformController
     */
    public function update(GamePlatformRequest $request, GamePlatform $gamePlatform)
    {
        $gamePlatform->company_id = intval($request->input('company_id', 0));
        $gamePlatform->name = $request->input('name', '');
        $gamePlatform->acronym = $request->input('acronym', '');
        $gamePlatform->sort_order = intval($request->input('sort_order'));
        $gamePlatform->wikipedia = $request->input('wikipedia');

        $gamePlatform->save();

        return redirect('game/platform/' . $gamePlatform->id);
    }
}
