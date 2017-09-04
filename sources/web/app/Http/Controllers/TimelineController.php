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
        //
        //
        //$timeline = Timeline::all();

        $client = new \MongoDB\Client("mongodb://localhost:27017");
        //$manager = new \MongoDB\Driver\Manager("mongodb://localhost:27017");
        //$query = new \MongoDB\Driver\Query([], []);
        //$cursor = $manager->executeQuery('test.users', $query);
        $collection = $client->test->users;

        return view('timeline.index', [
            'timelines' => $collection->find(),
        ]);
    }

    public function add()
    {

    }

}
