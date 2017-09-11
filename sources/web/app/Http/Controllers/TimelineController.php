<?php
/**
 * タイムラインコントローラー
 */

namespace Hgs3\Http\Controllers;

use Hgs3\Constants\UserRole;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Timeline;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    /**
     * タイムライン
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $client = new \MongoDB\Client("mongodb://localhost:27017");
        $collection = $client->test->users;

        $options = [
            'sort'  => ['time' => -1],
            'limit' => 30,
            'skip'  => 0
        ];


        return view('timeline.index', [
            'timelines' => $collection->find([], $options),
        ]);
    }

    public function add()
    {

    }
}
