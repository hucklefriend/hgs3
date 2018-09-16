<?php
/**
 * ゲームコントローラー
 */

namespace Hgs3\Http\Controllers\Network;

use Hgs3\Models\Orm;

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

        $this->network->load('game');

        return $this->result('ゲーム');
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
