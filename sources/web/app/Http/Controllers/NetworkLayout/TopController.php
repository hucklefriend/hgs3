<?php
/**
 * トップページコントローラー
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

class TopController extends Controller
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

        $network = NetworkLayout::load('title');

        return $this->result('', $network);
/*
        $notices = Orm\SystemNotice::select(['id', 'title', DB::raw('UNIX_TIMESTAMP(open_at) AS open_at_ts')])
            ->where('top_start_at', '<=', DB::raw('NOW()'))
            ->where('top_end_at', '>=', DB::raw('NOW()'))
            ->orderBy('open_at', 'DESC')
            ->get();

        $newInfo = NewInformation::get(time(), 10);

        return view('top', [
            'newInfo'    => $newInfo,
            'newInfoNum' => count($newInfo),
            'notices'    => $notices,
            'softNum'    => Soft::getNum(),
            'reviewNum'  => Review::getNum(),
            'siteNum'    => Site::getNum(),
            'userNum'    => User::getNum(),
            'newGames'   => Package::getNewGame()
        ]);
*/
    }
}
