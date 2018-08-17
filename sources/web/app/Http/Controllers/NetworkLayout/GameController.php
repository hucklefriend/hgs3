<?php
/**
 * ゲームコントローラー
 */

namespace Hgs3\Http\Controllers\NetworkLayout;

use Hgs3\Constants\PageId;
use Hgs3\Http\GlobalBack;
use Hgs3\Models\Game\Package;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\NetworkLayout;
use Hgs3\Models\Orm;
use Hgs3\Models\Review;
use Hgs3\Models\Site;
use Hgs3\Models\Timeline\NewInformation;
use Hgs3\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class GameController extends Controller
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

    public function phoneticList()
    {

    }

    public function releaseList()
    {

    }

    public function detail(Orm\GameSoft $soft)
    {

    }
}
