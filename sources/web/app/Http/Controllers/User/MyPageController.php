<?php
/**
 * マイページコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Hgs3\Models\User\Mongo;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Hgs3\Constants\TimelineType;
use Hgs3\Models\Timeline;

class MyPageController extends Controller
{
    const PER_PAGE = 20;

    /**
     * マイページ
     *
     * @return $this
     */
    public function index()
    {
        $collection = Timeline::getMongoCollection();

        $user = new Mongo(Auth::id());

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
        $pager->setPath('mypage');

        $options = [
            'sort'  => ['time' => -1],
            'limit' => self::PER_PAGE,
            'skip'  => ($pager->currentPage() - 1) * self::PER_PAGE
        ];



        return view('user.mypage')->with([
            'user'      => Auth::user(),
            'timelines' => $collection->find($filter, $options),
            'pager'     => $pager
        ]);
    }
}
