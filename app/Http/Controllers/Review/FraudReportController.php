<?php
/**
 * レビューの不正報告コントローラー
 */

namespace Hgs3\Http\Controllers\Review;

use Hgs3\Constants\Review\FraudReport\Status;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Orm\ReviewFraudReport;
use Hgs3\Models\Orm\Review;
use Hgs3\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FraudReportController extends Controller
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
        return view('review.fraudReport.alpha');

/*
        return view('review.fraudReport.report', [
            'review' => $review,
            'writer' => User::find($review->user_id)
        ]);
*/
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
        return view('review.fraudReport.alpha');
/*
        $type = $request->post('type', []);
        $comment = $request->post('comment', '');
        $anonymous = $request->post('anonymous', 0);

        if ((!is_array($type) || empty($type)) && empty($comment)) {
            // 空で送られているのでそのまま戻す
            return redirect()->back();
        }

        $fraudReport = new ReviewFraudReport();
        $fraudReport->review_id = $review->id;

        if (Auth::check() && $anonymous == 0) {
            $fraudReport->user_id = Auth::id();
        }

        $types = 0;
        foreach ($type as $key => $value) {
            $key = intval($key);

            if ($key == 0) {
                $types += 1;
            } else {
                $types += (10 ** $key) + 1;
            }
        }

        $fraudReport->types = $types;
        $fraudReport->comment = $comment ?? '';
        $fraudReport->stop_comment = 0;
        $fraudReport->status = Status::REPORTED;
        $fraudReport->ip_address = $request->ip();
        $fraudReport->save();

        return view('review.fraudReport.reportComplete');
*/
    }

    /**
     * 不正報告一覧
     *
     * @param Review $review
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Review $review)
    {
        return view('review.fraudReport.alpha');

/*
        $list = ReviewFraudReport:://where('review_id', $review->id)
            orderBy('id', 'DESC')
            ->paginate(15);

        return view('review.fraudReport.list', [
            'review' => $review,
            'writer' => User::find($review->user_id),
            'list'   => $list
        ]);
*/
    }
}
