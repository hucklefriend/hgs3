<?php
/**
 * ゲーム会社コントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Http\GlobalBack;
use Hgs3\Http\Requests\Game\GameCompanyRequest;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Orm;


class CompanyController extends Controller
{
    /**
     * 会社一覧
     *
     * @return $this
     */
    public function index()
    {
        $companies = Orm\GameMaker::orderBy('phonetic')
            ->get();

        return view('game.company.index', [
            'companies' => $companies
        ]);
    }

    /**
     * 会社詳細
     *
     * @param Orm\GameMaker $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Orm\GameMaker $company)
    {
        $data = $company->getSoft();

        return view('game.company.detail', [
            'company'  => $company,
            'soft'     => $data['soft'],
            'packages' => $data['packages']
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
        $company = new Orm\GameMaker;
        $company->name = $request->input('name', '');
        $company->phonetic = $request->input('phonetic', '');
        $company->acronym = $request->input('acronym', '');
        $company->url = $request->input('url');
        $company->wikipedia = $request->input('wikipedia');

        $company->save();

        return redirect()->route('ゲーム会社詳細', ['company' => $company->id]);
    }

    /**
     * 編集画面
     *
     * @param Orm\GameMaker $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Orm\GameMaker $company)
    {
        return view('game.company.edit', [
            'company' => $company
        ]);
    }

    /**
     * データ更新
     *
     * @param GameCompanyRequest $request
     * @param Orm\GameMaker $company
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(GameCompanyRequest $request, Orm\GameMaker $company)
    {
        $company->name = $request->input('name');
        $company->phonetic = $request->input('phonetic');
        $company->acronym = $request->input('acronym', '');
        $company->url = $request->input('url');
        $company->wikipedia = $request->input('wikipedia');

        $company->save();

        return redirect()->route('ゲーム会社詳細', ['company' => $company->id]);
    }
}
