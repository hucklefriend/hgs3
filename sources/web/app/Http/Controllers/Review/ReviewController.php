<?php
/**
 * レビューコントローラ
 */

namespace Hgs3\Http\Controllers\Review;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Review\WriteRequest;
use Hgs3\Models\Game\Package;
use Hgs3\Models\Review;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * レビュートップページ
     */
    public function index()
    {
        return view('review.index', Review::getTopPageData(5));
    }

    /**
     * 特定ゲームソフトのレビュー一覧
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function soft(Orm\GameSoft $soft)
    {
        $data = [
            'soft'  => $soft,
            'total' => null
        ];

        $total = Orm\ReviewTotal::find($soft->id);
        if ($total !== null) {
            $data['total'] = $total;
            $data['reviews'] = Review::getNewArrivalsBySoft($soft->id, 10);

            $pager = new LengthAwarePaginator([], $total->review_num, 10);
            $pager->setPath('');

            $data['pager'] = $pager;
        }

        return view('review.soft', $data);
    }

    /**
     * 今日の日付のintを取得(yyyymmdd)
     *
     * @return int
     */
    private function getDateInt()
    {
        $dt = new \DateTime();
        return intval($dt->format('Ymd'));
    }

    /**
     * 詳細
     *
     * @param Orm\Review $review
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Orm\Review $review)
    {
        $soft = Orm\GameSoft::find($review->soft_id);

        // 投稿者本人か
        $isWriter = $review->user_id == Auth::id();

        // いいね済みか
        $hasGood = false;
        if (!$isWriter) {
            //$hasGood = $r->hasGood($review->id, Auth::id());
        }

        return view('review.detail', [
            'soft'     => $soft,
            'packages' => $review->getPackages(),
            'review'   => $review,
            'isWriter' => $isWriter,
            'hasGood'  => $hasGood,
            'user'     => User::find($review->user_id)
        ]);
    }

    /**
     * 新着
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newArrivals()
    {
        $reviews = Orm\Review::orderBy('id', 'desc')
            ->paginate(20);

        return view('review.newArrivals', [
            'reviews'      => $reviews,
            'writers'      => User::getHash(array_pluck($reviews->items(), 'user_id')),
            'gamePackages' => Orm\GamePackage::getHash(array_pluck($reviews->items(), 'package_id'))
        ]);
    }
}
