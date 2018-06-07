<?php
/**
 * レビューコントローラ
 */

namespace Hgs3\Http\Controllers\Review;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Review;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ReviewController extends Controller
{
    /**
     * レビュートップページ
     */
    public function index()
    {
        return view('review.index', [
            'newArrivals'  => Review::getNewArrival(5),
            'wantToWrite'  => Review::getWantToWrite(),
            'fearRanking'  => Review::getFearRanking(),
            'pointRanking' => Review::getPointRanking(),
        ]);
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
            'soft'    => $soft,
            'total'   => null,
            'reviews' => []
        ];

        $data['total'] = Orm\ReviewTotal::find($soft->id);

        $data['reviews'] = Orm\Review::where('soft_id', $soft->id)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        $data['users'] = [];

        if ($data['reviews']->isNotEmpty()) {
            $data['users'] = User::getHash(page_pluck($data['reviews'], 'user_id'));
        }

        if (Auth::check()) {
            $data['writtenReview'] = Review::getByUserAndSoft(Auth::id(), $soft->id);
            $data['isWriteDraft'] = Review::isWriteDraft(Auth::id(), $soft->id);
        }

        return view('review.soft', $data);
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

        // 印象
        $impression = 0;
        if (Auth::check()) {
            $impression = Review\Impression::get(Auth::id(), $review->id);
        }

        return view('review.detail', [
            'soft'       => $soft,
            'packages'   => $review->getPackages(),
            'review'     => $review,
            'isWriter'   => $isWriter,
            'user'       => User::find($review->user_id),
            'impression' => $impression
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

    /**
     * レビューについて
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        return view('review.about');
    }
}
