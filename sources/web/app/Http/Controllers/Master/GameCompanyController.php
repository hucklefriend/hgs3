<?php
namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameCompanyController extends Controller
{
    public function list()
    {
        $companies = \App\Models\Orm\GameCompany::All();

        return view('master.game_company.list')->with([
            "list"   => $companies,
            "test_2" => "テスト2",
        ]);
    }

    public function detail()
    {

    }
}
