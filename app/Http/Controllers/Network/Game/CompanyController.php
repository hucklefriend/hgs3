<?php
/**
 * ゲームコントローラー
 */

namespace Hgs3\Http\Controllers\Network\Game;

use Hgs3\Http\Controllers\Network\Controller;
use Hgs3\Http\GlobalBack;
use Hgs3\Models\NetworkLayout;
use Hgs3\Models\Orm;
use Hgs3\Network;

class CompanyController extends Controller
{
    /**
     * ゲーム会社一覧
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function index()
    {
        $this->setViewPath();

        $this->network->load('game-company');

        $data = Orm\GameMaker::orderBy('phonetic')
            ->paginate(100);

        $index = 0;
        foreach ($data->items() as $company) {
            $x = $index % 6;
            $y = intval($index / 6) + 1;

            $item = new Network\Item();

            $item->id = 'company_' . $company->id;
            $item->parentId = 'company-list';
            $item->view = 'game.company.company';
            $item->viewData = ['company' => $company];
            $item->setPositionParentOffset($x * 150 - 200, $y * 60);


            $this->network->addItem($item);
            $index++;
        }

        //NetworkLayout::appendChild($network);



        return $this->result('ゲーム会社');
    }

    public function detail(Orm\GameMaker $company)
    {

    }
}
