<?php
/**
 * 不正レビューコントローラー
 */

namespace Hgs3\Http\Controllers\Admin;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\InjusticeReview;

class InjusticeReviewController extends Controller
{
    /**
     * 不正レビュー一覧
     */
    public function index()
    {
        $ir = new InjusticeReview();
        return view('admin.review.index')->with($ir->getList());
    }
}
