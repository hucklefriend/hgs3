<?php
/**
 * 不正レビューコントローラ
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Constants\InjusticeStatus;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InjusticeReviewController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'review');
    }

    /**
     * 不正報告入力画面
     *
     * @param Orm\Review $review
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function input(\Hgs3\Models\Orm\Review $review)
    {
        return view('game.injustice_review.input', [
            'review' => $review,
            'pkg'    => GamePackage::find($review->package_id),
            'writer' => User::find($review->user_id)
        ]);
    }

    /**
     * 不正報告完了
     *
     * @param Request $request
     * @param \Hgs3\Models\Orm\Review $review
     * @return $this
     */
    public function report(Request $request, \Hgs3\Models\Orm\Review $review)
    {
        $injustice = new ReviewFraudReport();
        $injustice->review_id = $review->id;

        if ($request->get('anonymous') == 1) {
            $injustice->user_id = null;
        } else {
            $injustice->user_id = Auth::id();
        }

        $injustice->comment = $request->input('comment') ?? '';
        $injustice->status = InjusticeStatus::NOT_DOING_ANYTHING;
        $injustice->stop_comment = 0;

        $injustice->save();

        return view('game.injustice_review.report')->with([
            'review' => $review
        ]);
    }

    /**
     * 不正報告リスト
     *
     * @param \Hgs3\Models\Orm\Review $review
     * @return $this
     */
    public function list(\Hgs3\Models\Orm\Review $review)
    {
        $data = ReviewFraudReport::where('review_id', $review->id)
            ->orderBy('id', 'DESC')
            ->paginate();

        $users = [];
        if (!empty($data)) {
            $users = User::getNameHash(array_pluck($data->items(), 'user_id'));
        }
        $users[null] = '匿名';

        return view('game.injustice_review.list')->with([
            'review' => $review,
            'pkg'    => GamePackage::find($review->package_id),
            'writer' => User::find($review->user_id),
            'data'   => $data,
            'users'  => $users
        ]);
    }

    /**
     * 詳細
     *
     * @param \Hgs3\Models\Orm\ReviewFraudReport $ir
     */
    public function detail(ReviewFraudReport $ir)
    {
        $review = Review::find($ir->review_id);

        return view('game.injustice_review.detail')->with([
            'review'   => $review,
            'pkg'      => GamePackage::find($review->package_id),
            'writer'   => User::find($review->user_id),
            'reporter' => User::find()
        ]);
    }

    /**
     * コメントする
     *
     * @param \Hgs3\Models\Orm\Review $review
     */
    public function comment(ReviewFraudReport $ir)
    {
        $c = new ReviewFraudReportComment;



    }
}