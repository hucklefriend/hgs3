<?php
/**
 * レビューの印象コントローラ
 */

namespace Hgs3\Http\Controllers\Review;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Review;
use Hgs3\Models\Orm;
use Hgs3\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ImpressionController extends Controller
{
    /**
     * いいね
     *
     * @param Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function impression(Orm\Review $review)
    {
        if ($review->user_id != Auth::id() && !Review::hasGood(Auth::id(), $review->id)) {
            Review::good($review, Auth::user());
        }

        return redirect()->back();
    }

    /**
     * 取り消し
     *
     * @param Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function update(Orm\Review $review)
    {
        if ($review->user_id != Auth::id() && Review::hasGood(Auth::id(), $review->id)) {
            Review::cancelGood($review, Auth::user());
        }

        return redirect()->back();
    }

    public function delete()
    {

    }
}
