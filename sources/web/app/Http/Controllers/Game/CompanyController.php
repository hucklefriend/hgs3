<?php
/**
 * ゲーム会社コントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Http\Requests\Game\GameCompanyRequest;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Collection;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'game');
    }

    /**
     * 会社一覧
     *
     * @return $this
     */
    public function index()
    {
        $companies = Orm\GameCommunity::orderBy('phonetic')
            ->paginate(30);

        return view('game.company.index', [
            'companies' => $companies
        ]);
    }

    /**
     * 会社詳細
     *
     * @param Orm\GameCompany $gameCompany
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Orm\GameCompany $gameCompany)
    {
        return view('game.company.detail', [
            'company' => $gameCompany,
            'detail'  => $company->getDetail($gameCompany),
        ]);
    }

    /**
     * 追加画面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('game.company.add');
    }

    /**
     * データ追加
     *
     * @param GameCompanyRequest $request
     * @return CompanyController
     */
    public function insert(GameCompanyRequest $request)
    {
        $gameCompany = new Orm\GameCompany;
        $gameCompany->name = $request->input('name', '');
        $gameCompany->phonetic = $request->input('phonetic', '');
        $gameCompany->url = $request->input('url');
        $gameCompany->wikipedia = $request->input('wikipedia');

        $gameCompany->save();

        return redirect('game/company');
    }

    /**
     * 編集画面
     *
     * @param Orm\GameCompany $gameCompany
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Orm\GameCompany $gameCompany)
    {
        return view('game.company.edit', [
            'gameCompany' => $gameCompany
        ]);
    }

    /**
     * データ更新
     *
     * @param GameCompanyRequest $request
     * @param Orm\GameCompany $gameCompany
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(GameCompanyRequest $request, Orm\GameCompany $gameCompany)
    {
        $gameCompany->name = $request->input('name');
        $gameCompany->phonetic = $request->input('phonetic');
        $gameCompany->url = $request->input('url');
        $gameCompany->wikipedia = $request->input('wikipedia');

        $gameCompany->save();

        return redirect('game/company/detail/' . $gameCompany->id);
    }
}
