<?php
namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Orm;

class GameCompanyController extends Controller
{
    public function list()
    {
        $companies = GameCompany::All();

        return view('master.game_company.list')->with([
            "list"   => $companies,
            "test_2" => "テスト2",
        ]);
    }

    public function detail($id)
    {

    }

    public function add()
    {
        return view('master.game_company.add');
    }

    public function edit()
    {

    }

    public function postAdd(AddGameCompanyRequest $request)
    {

    }
}
