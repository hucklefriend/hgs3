<?php
/**
 * ゲーム会社コントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Constants\UserRole;
use Hgs3\Http\Requests\Game\GameCompanyRequest;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Collection;
use Hgs3\Models\Orm\GameCompany;
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
        $company = new Collection;

        return view('game.company.list', [
            'companies' => $company->getList()
        ]);
    }

    /**
     * 会社詳細
     *
     * @param GameCompany $gameCompany
     * @return $this
     */
    public function show(GameCompany $gameCompany)
    {
        $company = new Collection;

        return view('game.company.detail')->with([
            'company' => $gameCompany,
            'detail'  => $company->getDetail($gameCompany),
            'isAdmin' => UserRole::isAdmin()
        ]);
    }

    /**
     * ゲーム会社追加
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('game.company.add');
    }

    /**
     * ゲーム会社追加
     *
     * @param GameCompanyRequest $request
     * @return CompanyController
     */
    public function insert(GameCompanyRequest $request)
    {
        $gameCompany = new GameCompany;
        $gameCompany->name = $request->input('name', '');
        $gameCompany->phonetic = $request->input('phonetic', '');
        $gameCompany->url = $request->input('url');
        $gameCompany->wikipedia = $request->input('wikipedia');

        $gameCompany->save();

        return redirect('game/company');
    }

    /**
     * データ編集
     *
     * @param GameCompany $gameCompany
     * @return $this
     */
    public function edit(GameCompany $gameCompany)
    {
        return view('game.company.edit')->with([
            'gameCompany' => $gameCompany
        ]);
    }

    /**
     * データ更新
     *
     * @param GameCompanyRequest $request
     * @param GameCompany $gameCompany
     * @return CompanyController
     */
    public function update(GameCompanyRequest $request, GameCompany $gameCompany)
    {
        $gameCompany->name = $request->input('name');
        $gameCompany->phonetic = $request->input('phonetic');
        $gameCompany->url = $request->input('url');
        $gameCompany->wikipedia = $request->input('wikipedia');

        $gameCompany->save();

        return redirect('game/company/detail/' . $gameCompany->id);
    }
}
