<?php
/**
 * タイムラインコントローラー
 */

namespace Hgs3\Http\Controllers;

use Hgs3\Constants\TimelineType;
use Hgs3\Constants\UserRole;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    const PER_PAGE = 3;

    /**
     * タイムライン
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tl = new Timeline();
        $collection = $tl->getMongoCollection();

        $num = $collection->count();

        $pager = new LengthAwarePaginator([], $num, self::PER_PAGE);
        $pager->setPath('timeline');

        $options = [
            'sort'  => ['time' => -1],
            'limit' => self::PER_PAGE,
            'skip'  => ($pager->currentPage() - 1) * self::PER_PAGE
        ];

        return view('timeline.index', [
            'timelines' => $collection->find([], $options),
            'pager'     => $pager
        ]);
    }

    /**
     * タイムライン登録画面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function input()
    {
        return view('timeline.input');
    }

    /**
     * 追加
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
        $timelineType = $request->get('type');
        $tl = new Timeline();

        switch($timelineType) {
            case TimelineType::NEW_GAME_SOFT:
                $tl->addNewGameSoftText($request->get('game_id'), null);
                break;
            case TimelineType::UPDATE_GAME_SOFT:
                $tl->addUpdateGameSoftText($request->get('game_id'), null);
                break;
        }

        return redirect()->back();
    }

    /**
     * 削除
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        $id = $request->get('id');

        $tl = new Timeline();
        $collection = $tl->getMongoCollection();
        $collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectID($id)]);

        return redirect()->back();
    }
}
