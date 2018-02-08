<?php
/**
 * ゲームソフトコントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Constants\PhoneticType;
use Hgs3\Http\Requests\Game\GameSoftRequest;
use Hgs3\Models\Orm;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Soft;

class SoftController extends Controller
{
    /**
     * 一覧ページ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('game.soft.index', [
            'phoneticList' => PhoneticType::getId2CharData(),
            'list'         => Soft::getList()
        ]);
    }

    /**
     * 詳細ページ
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Orm\GameSoft $soft)
    {
        // TODO 発売日が過ぎていないとレビューを投稿するリンクは出さない

        $data = Soft::getDetail($soft);
        $data['useChart'] = true;

        return view('game.soft.detail', $data);
    }

    /**
     * パッケージIDからゲーム詳細に飛ぶ
     *
     * @param $packageId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function detailByPackage($packageId)
    {
        $packageLink = Orm\GamePackageLink::where('package_id', $packageId)
            ->orderBy('soft_id')
            ->first();

        if (!empty($packageLink)) {
            return redirect()->route('ゲーム詳細', ['soft' => $packageLink->soft_id]);
        } else {
            return abort(404);
        }
    }

    /**
     * 追加フォーム
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('game.soft.add');
    }

    /**
     * 追加
     *
     * @param GameSoftRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function insert(GameSoftRequest $request)
    {
        $soft = new Orm\GameSoft();

        $soft->name = $request->get('name');
        $soft->phonetic = $request->get('phonetic');
        $soft->phonetic_type = PhoneticType::getTypeByPhonetic($soft->phonetic);
        $soft->phonetic_order = 99999;
        $soft->genre = $request->get('genre', '');
        $soft->series_id = $request->get('series_id', null);
        $soft->order_in_series = $request->get('order_in_series', null);

        Soft::save($soft, true);

        return redirect()->route('ゲーム詳細', ['soft' => $soft->id]);
    }

    /**
     * 編集画面
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Orm\GameSoft $soft)
    {
        return view('game.soft.edit', [
            'soft' => $soft
        ]);
    }

    /**
     * データ更新
     *
     * @param GameSoftRequest $request
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(GameSoftRequest $request, Orm\GameSoft $soft)
    {
        $soft->name = $request->get('name');
        $soft->phonetic = $request->get('phonetic', '');
        $soft->phonetic_type = PhoneticType::getTypeByPhonetic($soft->phonetic);
        $soft->genre = $request->get('genre') ?? '';
        $soft->series_id = $request->get('series_id');
        $soft->order_in_series = $request->get('order_in_series');

        Soft::save($soft, true);

        return redirect()->route('ゲーム詳細', ['soft' => $soft->id]);
    }
}
