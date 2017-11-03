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
     * @param Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function good(Orm\Review $review)
    {
        // TODO 同じレビューにいいねをできる回数を制限するか、
        // 履歴に残して最初のいいねだけをタイムラインに残す？

        $r = new Review();
        if (!$r->hasGood($review->id, Auth::id())) {
            $r->good($review, Auth::user());
        }

        return redirect()->back();
    }

    /**
     * いいね取り消し
     *
     * @param Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Orm\Review $review)
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
     * @param Orm\Review $review
     * @return $this
     */
    public function history(Orm\Review $review)
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

        return view('review.goodHistory', [
            'user'      => Auth::user(),
            'review'    => $review,
            'histories' => $his,
            'users'     => $users
        ]);
    }
}
