<?php
/**
 * 不正レビューコントローラー
 */

namespace Hgs3\Http\Controllers\Review;

use Hgs3\Constants\Review\Injustice\Status;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Orm\InjusticeReview;
use Hgs3\Models\Orm\Review;
use Hgs3\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class InjusticeReviewController extends Controller
{
    /**
     * コンストラクタ
     *
     * @return void
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'review');
    }

    /**
     * 不正入力画面
     *
     * @param Review $review
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function input(Review $review)
    {

        return view('review.injustice.report', [
            'review' => $review,
            'writer' => User::find($review->user_id)
        ]);
    }

    /**
     * 不正報告
     *
     * @param Request $request
     * @param Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function report(Request $request, Review $review)
    {
        $type = $request->post('type', []);
        $comment = $request->post('comment', '');
        $anonymous = $request->post('anonymous', 0);

        if ((!is_array($type) || empty($type)) && empty($comment)) {
            // 空で送られているのでそのまま戻す
            return redirect()->back();
        }

        $injusticeReview = new InjusticeReview();
        $injusticeReview->review_id = $review->id;

        if (Auth::check() && $anonymous == 0) {
            $injusticeReview->user_id = Auth::id();
        }

        $types = 0;
        foreach ($type as $key => $value) {
            $key = intval($key);

            if ($key > 0) {
                $types += $key + 1;
            } else {
                $types += 10 ** $key + 1;
            }
        }

        $injusticeReview->types = $types;
        $injusticeReview->comment = $comment;
        $injusticeReview->stop_comment = 0;
        $injusticeReview->status = Status::REPORTED;
        $injusticeReview->save();

        return view('review.injustice.reportComplete');
    }
}
