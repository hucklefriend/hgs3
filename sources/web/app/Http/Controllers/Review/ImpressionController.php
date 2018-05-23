<?php
/**
 * レビューの印象コントローラ
 */

namespace Hgs3\Http\Controllers\Review;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Review;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\Auth;

class ImpressionController extends Controller
{
    /**
     * ふむふむ
     *
     * @param Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function fmfm(Orm\Review $review)
    {
        if (Review\Impression::has(Auth::id(), $review->id)) {
            // 削除
            Review\Impression::cancel(Auth::user(), $review);
        }

        // ふむふむ実行
        Review\Impression::fmfm(Auth::user(), $review);

        return redirect()->back();
    }

    /**
     * んー…
     *
     * @param Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function n(Orm\Review $review)
    {
        if (Review\Impression::has(Auth::id(), $review->id)) {
            // 削除
            Review\Impression::cancel(Auth::user(), $review);
        }

        // んー…実行
        Review\Impression::n(Auth::user(), $review);

        return redirect()->back();
    }

    /**
     * 取り消し
     *
     * @param Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Orm\Review $review)
    {
        if (Review\Impression::has(Auth::id(), $review->id)) {
            // 削除
            Review\Impression::cancel(Auth::user(), $review);
        }

        return redirect()->back();
    }
}
