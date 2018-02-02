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
     */
    public function index()
    {
        $soft = new Soft;

        return view('game.soft.index')->with([
            'phoneticList' => PhoneticType::getId2CharData(),
            'list'         => $soft->getList(),
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function insert(GameSoftRequest $request)
    {
        $soft = new Orm\GameSoft();

        $soft->name = $request->get('name');
        $soft->phonetic = $request->get('phonetic');
        $soft->phonetic_type = PhoneticType::getTypeByPhonetic($soft->phonetic);
        $soft->phonetic_order = 99999;
        $soft->genre = $request->get('genre', '');
        $soft->company_id = $request->get('company_id', null);
        $soft->series_id = $request->get('series_id', null);
        $soft->order_in_series = $request->get('order_in_series', null);
        $soft->game_type = 0;

        Soft::save($soft, true);

        return redirect('game/soft/' . $soft->id);
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
        $soft->company_id = $request->get('company_id');
        $soft->series_id = $request->get('series_id');
        $soft->order_in_series = $request->get('order_in_series');
        $soft->game_type = $request->get('game_type');

        Soft::save($soft, true);

        return redirect('game/soft/' . $soft->id);
    }
}
