<?php
/**
 * レビューのいいねコントローラ
 */

namespace Hgs3\Http\Controllers\Review;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Review;
use Hgs3\Models\Orm;
use Hgs3\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class GoodController extends Controller
{
    /**
     * いいね
     *
     * @param Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function good(Orm\Review $review)
    {
        if ($review->user_id != Auth::id() && !Review::hasGood($review->id, Auth::id())) {
            Review::good($review, Auth::user());
        }

        return redirect()->back();
    }

    /**
     * いいね取り消し
     *
     * @param Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function cancel(Orm\Review $review)
    {
        if ($review->user_id != Auth::id() && Review::hasGood($review->id, Auth::id())) {
            Review::cancelGood($review, Auth::user());
        }

        return redirect()->back();
    }
}
