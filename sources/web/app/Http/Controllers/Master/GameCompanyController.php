<?php
namespace Hgs3\Http\Controllers\Master;

use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests;
use Hgs3\Models\Orm\GameCompany;

class GameCompanyController extends Controller
{
    public function index()
    {
        $companies = GameCompany::All();

        return view('master.game_company.list')->with([
            "list"   => $companies
        ]);
    }

    public function show(GameCompany $gameCompany)
    {
        return view('master.game_company.detail')->with([
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
        $gameCompany = new GameCompany;
        $gameCompany->name = $request->input('name');
        $gameCompany->name_hiragana = $request->input('name_hiragana');
        $gameCompany->url = $request->input('url');

        $gameCompany->save();

        return $this->index();
    }

    public function edit(GameCompany $gameCompany)
    {
        return view('master.game_company.edit')->with([
            'gameCompany' => $gameCompany
        ]);
    }

    public function update(Request $request, GameCompany $gameCompany)
    {
        $gameCompany->name = $request->input('name');
        $gameCompany->name_hiragana = $request->input('name_hiragana');
        $gameCompany->url = $request->input('url');

        $gameCompany->save();

        return $this->edit($gameCompany);
    }

    public function destroy(GameCompany $gameCompany)
    {
        $gameCompany->delete();

        return $this->index();
    }
}
