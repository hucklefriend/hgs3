<?php
/**
 * トップページコントローラー
 */

namespace Hgs3\Http\Controllers\Network;

class TopController extends Controller
{
    /**
     * トップページ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function index()
    {
        $this->setViewPath();

        $this->network->load('title');

        return $this->result('');
    }
}
