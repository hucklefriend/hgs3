<?php
/**
 * レビューのいいねコントローラ
 */

namespace Hgs3\Http\Controllers\Review;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Review\WriteRequest;
use Hgs3\Models\Review\Review;
use Hgs3\Models\Orm\GameSoft;
use Hgs3\Models\Orm\GamePackage;
use Hgs3\Models\Orm\ReviewDraft;
use Hgs3\Models\Orm\ReviewTotal;
use Hgs3\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class GoodController extends Controller
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
     * いいね
     *
     * @param \Hgs3\Models\Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function good(\Hgs3\Models\Orm\Review $review)
    {
        // TODO 同じレビューにいいねをできる回数を制限するか、
        // 履歴に残して最初のいいねだけをタイムラインに残す？

        $r = new Review();
        if (!$r->hasGood($review->id, Auth::id())) {
            $r->good($review, Auth::id());
        }

        return redirect()->back();
    }

    /**
     * いいね取り消し
     *
     * @param \Hgs3\Models\Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(\Hgs3\Models\Orm\Review $review)
    {
        $r = new Review();
        if ($r->hasGood($review->id, Auth::id())) {
            $r->cancelGood($review, Auth::id());
        }

        return redirect()->back();
    }

    /**
     * いいね履歴
     *
     * @param \Hgs3\Models\Orm\Review $review
     */
    public function history(\Hgs3\Models\Orm\Review $review)
    {
        // 投稿者本人しか見られない
        if ($review->user_id != Auth::id()) {
            // 他のユーザーのデータを編集しようとしている
            App::abort(403);
        }

        $his = $review->getGoodHistory();
        $users = [];
        if (!empty($his)) {
            $users = User::getHash(array_pluck($his->items(), 'user_id'));
        }

        return view('review.goodHistory')->with([
            'user'      => Auth::user(),
            'review'    => $review,
            'histories' => $his,
            'users'     => $users
        ]);
    }
}
