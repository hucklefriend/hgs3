<?php
/**
 * 不正レビューコントローラ
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Constants\InjusticeStatus;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Orm\GamePackage;
use Hgs3\Models\Orm\InjusticeReview;
use Hgs3\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class InjusticeReviewController extends Controller
{
    /**
     * 不正報告リスト
     *
     * @param \Hgs3\Models\Orm\Review $review
     * @return $this
     */
    public function index()
    {



        return view('game.injustice_review.list')->with([
            'review' => $review,
            'pkg'    => GamePackage::find($review->package_id),
            'writer' => User::find($review->user_id)
        ]);
    }

}