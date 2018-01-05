<?php
/**
 * ゲーム会社マスター
 */

namespace Hgs3\Http\Controllers\Master;

use Hgs3\Http\Requests\Master\GameCompanyRequest;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Orm;

class GameCompanyController extends Controller
{
    /**
     * 一覧
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $gameCompanies = Orm\GameCompany::All();

        return view('master.game_company.list', [
            'gameCompanies' => $gameCompanies
        ]);
    }

    /**
     * 詳細
     *
     * @param Orm\GameCompany $gameCompany
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Orm\GameCompany $gameCompany)
    {
        return view('master.game_company.detail', [
            'gameCompany' => $gameCompany
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.game_company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gameCompany = new Orm\GameCompany;
        $gameCompany->name = $request->input('name');
        $gameCompany->name_hiragana = $request->input('name_hiragana');
        $gameCompany->url = $request->input('url');

        $gameCompany->save();

        return $this->index();
    }

    /**
     * 編集画面
     *
     * @param Orm\GameCompany $gameCompany
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Orm\GameCompany $gameCompany)
    {
        return view('master.game_company.edit', [
            'gameCompany' => $gameCompany,
            'isComplete'  => false
        ]);
    }

    /**
     * 編集処理
     *
     * @param Request $request
     * @param Orm\GameCompany $gameCompany
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(GameCompanyRequest $request, Orm\GameCompany $gameCompany)
    {
        $gameCompany->name = $request->input('name');
        $gameCompany->acronym = $request->input('acronym');
        $gameCompany->phonetic = $request->input('phonetic');
        $gameCompany->url = $request->input('url');
        $gameCompany->wikipedia = $request->input('wikipedia');

        $gameCompany->save();

        return view('master.game_company.edit', [
            'gameCompany' => $gameCompany,
            'isComplete'  => true
        ]);
    }

    public function destroy(Orm\GameCompany $gameCompany)
    {
        $gameCompany->delete();

        return $this->index();
    }
}
