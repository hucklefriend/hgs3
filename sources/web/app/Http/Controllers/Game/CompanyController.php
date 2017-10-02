<?php
namespace Hgs3\Http\Controllers\Game;

use Hgs3\Constants\UserRole;
use Hgs3\Http\Requests\AddGameCompanyRequest;
use Hgs3\Http\Requests\UpdateGameCompanyRequest;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Company;
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

    public function index()
    {
        $company = new Company;

        return view('game.company.list')->with([
            'companies' => $company->getList()
        ]);
    }

    public function show(GameCompany $gameCompany)
    {
        $company = new Company;

        return view('game.company.detail')->with([
            'company' => $gameCompany,
            'detail'  => $company->getDetail($gameCompany),
            'isAdmin' => UserRole::isAdmin()
        ]);
    }


    public function create()
    {
        return view('game.company.create');
    }

    public function store(AddGameCompanyRequest $request)
    {
        $gameCompany = new GameCompany;
        $gameCompany->name = $request->input('name');
        $gameCompany->phonetic = $request->input('phonetic');
        $gameCompany->url = $request->input('url');
        $gameCompany->wikipedia = $request->input('wikipedia');

        $gameCompany->save();

        return $this->index();
    }

    public function edit(GameCompany $gameCompany)
    {
        return view('game.company.edit')->with([
            'gameCompany' => $gameCompany
        ]);
    }

    public function update(UpdateGameCompanyRequest $request, GameCompany $gameCompany)
    {
        $gameCompany->name = $request->input('name');
        $gameCompany->phonetic = $request->input('phonetic');
        $gameCompany->url = $request->input('url');
        $gameCompany->wikipedia = $request->input('wikipedia');

        $gameCompany->save();

        return $this->edit($gameCompany);
    }
}
