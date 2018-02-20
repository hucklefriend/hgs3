<?php
/**
 * タイムラインコントローラー
 */

namespace Hgs3\Http\Controllers;

use Hgs3\Constants\TimelineType;
use Hgs3\Models\User\Mongo;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TimelineController extends Controller
{
    const PER_PAGE = 30;

    /**
     * タイムライン
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $collection = Timeline::getMongoCollection();

        $user = new Mongo(1);

        $filter = [
            '$or' => [
                ['target_user_id' => 1],
                ['game_id' => ['$in' => $user->getFavoriteGame()]],
                ['user_id' => ['$in' =>$user->getFollow()]],
                ['site_id' => ['$in' =>$user->getFavoriteSite()]]
            ],
            'user_id' => ['$ne' => 1]
        ];

        $num = $collection->count($filter);

        $pager = new LengthAwarePaginator([], $num, self::PER_PAGE);
        $pager->setPath($request->url());

        $options = [
            'sort'  => ['time' => -1],
            'limit' => self::PER_PAGE,
            'skip'  => ($pager->currentPage() - 1) * self::PER_PAGE
        ];

        return view('timeline.index', [
            'timelines' => $collection->find($filter, $options),
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

        switch($timelineType) {
            case TimelineType::NEW_GAME_SOFT:
                Timeline::addNewGameSoftText($request->get('game_id'), null);
                break;
            case TimelineType::UPDATE_GAME_SOFT:
                Timeline::addUpdateGameSoftText($request->get('game_id'), null);
                break;
            case TimelineType::FAVORITE_GAME:
                Timeline::addFavoriteGameText($request->get('game_id'), null, $request->get('user_id'), null);
                break;
            case TimelineType::NEW_REVIEW:
                Timeline::addNewReviewText($request->get('review_id'), $request->get('user_id'), null, $request->get('game_id'), null);
                break;
            case TimelineType::REVIEW_GOOD:
                Timeline::addReviewGoodText($request->get('review_id'), $request->get('user_id'), null, null);
                break;
            case TimelineType::NEW_SITE:
                Timeline::addNewSite($request->get('user_id'), null, $request->get('site_id'), null);
                break;
            case TimelineType::UPDATE_SITE:
                Timeline::addNewSite($request->get('user_id'), null, $request->get('site_id'), null);
                break;
            case TimelineType::NEW_FOLLOWER:
                Timeline::addNewFollower($request->get('follower_id'), null, $request->get('user_id'));
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

        $collection = Timeline::getMongoCollection();
        $collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectID($id)]);

        return redirect()->back();
    }
}
