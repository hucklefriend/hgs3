<?php
/**
 * レビュー承認コントローラ
 */

namespace Hgs3\Http\Controllers\Review;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Orm;
use Hgs3\Models\Review;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    /**
     * URL承認待ち一覧
     */
    public function index()
    {
        $reviewIds = Orm\ReviewWaitUrl::all('review_id')->pluck('review_id');
        if (!empty($reviewIds)) {
            $reviews = Orm\Review::whereIn('id', $reviewIds)->get();
        } else {
            $reviews = null;
        }

        return view('review.approval.index', [
            'reviews' => $reviews
        ]);
    }

    /**
     * URLを承認する
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function ok(Request $request)
    {
        $reviewId = $request->get('review_id');
        Review\Approval::approveUrl($reviewId);

        return redirect()->back();
    }

    /**
     * URLを否認する
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ng(Request $request)
    {
        $reviewId = $request->get('review_id');
        Review\Approval::denyUrl($reviewId);

        return redirect()->back();
    }
}
