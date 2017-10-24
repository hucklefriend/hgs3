<?php
/**
 * ゲーム会社コントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Http\Requests\Game\GameCompanyRequest;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Collection;
use Hgs3\Models\Game\Package;
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
     * @param Orm\GameCompany $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Orm\GameCompany $company)
    {
        $packages = Orm\GamePackage::where('company_id', $company->id)
            ->orderBy('release_int')
            ->paginate(15);

        $shops = [];
        $items = $packages->items();
        if (!empty($items)) {
            \ChromePhp::info($items);
            $shops = Package::getShopData(array_pluck($items, 'id'));
        }

        return view('game.company.detail', [
            'company'  => $company,
            'packages' => $packages,
            'shops'    => $shops
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
        $company = new Orm\GameCompany;
        $company->name = $request->input('name', '');
        $company->phonetic = $request->input('phonetic', '');
        $company->url = $request->input('url');
        $company->wikipedia = $request->input('wikipedia');

        $company->save();

        return redirect('game/company');
    }

    /**
     * 編集画面
     *
     * @param Orm\GameCompany $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Orm\GameCompany $company)
    {
        return view('game.company.edit', [
            'company' => $company
        ]);
    }

    /**
     * データ更新
     *
     * @param GameCompanyRequest $request
     * @param Orm\GameCompany $company
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(GameCompanyRequest $request, Orm\GameCompany $company)
    {
        $company->name = $request->input('name');
        $company->phonetic = $request->input('phonetic');
        $company->url = $request->input('url');
        $company->wikipedia = $request->input('wikipedia');

        $company->save();

        return redirect('game/company/detail/' . $company->id);
    }
}
