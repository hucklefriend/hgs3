<?php
/**
 * ゲームコントローラー
 */

namespace Hgs3\Http\Controllers\NetworkLayout\Game;

use Hgs3\Http\Controllers\NetworkLayout\Controller;
use Hgs3\Http\GlobalBack;
use Hgs3\Models\NetworkLayout;
use Hgs3\Models\Orm;

class CompanyController extends Controller
{
    /**
     * トップページ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->setViewPath();

        GlobalBack::clear();

        $network = NetworkLayout::load('game');


        //NetworkLayout::appendChild($network);



        return $this->result('ゲーム', $network);
    }

    public function detail(Orm\GameCompany $company)
    {

    }
}
