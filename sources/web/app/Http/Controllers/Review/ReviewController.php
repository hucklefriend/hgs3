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
            $users = User::getHash(page_pluck($data['reviews'], 'user_id'));
            foreach ($data['reviews'] as &$review) {
                $review->user = $users[$review->user_id];
            }
        }

        if (Auth::check()) {
            $data['writtenReview'] = Review::getByUserAndSoft(Auth::id(), $soft->id);
            $data['isWriteDraft'] = Review::isWriteDraft(Auth::id(), $soft->id);
        }

        $data['fearRanking'] = Orm\ReviewFearRanking::find($soft->id);
        $data['pointRanking'] = Orm\ReviewPointRanking::find($soft->id);

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
     * @throws \Exception
     */
    public function newArrivals()
    {
        $date = new \DateTime();
        $date->sub(new \DateInterval('P3M'));

        $reviews = Orm\Review::where('post_at', '>=', $date->format('Y-m-d 00:00:00'))
            ->orderBy('id', 'desc')
            ->paginate(20);

        if ($reviews->isNotEmpty()) {
            $writers = User::getHash(page_pluck($reviews, 'user_id'));
            $soft = Orm\GameSoft::getHash(page_pluck($reviews, 'soft_id'));

            foreach ($reviews as &$review) {
                $review->user = $writers[$review->user_id];
                $review->soft = $soft[$review->soft_id];
            }

        }

        return view('review.newArrivals', [
            'reviews'      => $reviews,
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
