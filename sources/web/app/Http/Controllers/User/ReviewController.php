<?php
/**
 * ユーザーレビューコントローラ
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Review\WriteRequest;
use Hgs3\Models\Game\Package;
use Hgs3\Models\Review;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     *
     */
    public function index()
    {
        return view('review.index', Review::getTopPageData(5));
    }

    /**
     * 入力画面
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function input(Orm\GameSoft $soft)
    {
        // 下書きを取得
        $draft = Orm\ReviewDraft::getData(Auth::id(), $soft->id);

        return view('user.review.input', [
            'soft'     => $soft,
            'packages' => $soft->getPackages(),
            'draft'    => $draft,
        ]);
    }

    /**
     * 確認
     *
     * @param Orm\gameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm(Orm\gameSoft $soft)
    {
        $draft = new Orm\ReviewDraft;
        $this->setDraftData($request, $draft);

        return view('user.review.confirm', [
            'soft'    => $soft,
            'package' => $package,
            'user'    => Auth::user(),
            'draft'   => $draft
        ]);
    }

    /**
     * 保存
     *
     * @param WriteRequest $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function save(WriteRequest $request)
    {
        $draft = new Orm\ReviewDraft;
        $this->setDraftData($request, $draft);

        Review::saveDraft($draft, $request->get('good_tags', []), $request->get('very_good_tags', []),
            $request->get('bad_tags', []), $request->get('very_bad_tags', []));

        redirect()->route('レビュー投稿確認', ['soft' => $draft->soft_id]);
    }

    /**
     * 下書きモデルに値をセット
     *
     * @param WriteRequest $request
     * @param Orm\ReviewDraft $draft
     */
    private function setDraftData(WriteRequest $request, Orm\ReviewDraft $draft)
    {
        $draft->user_id = \Auth::id();
        $draft->soft_id = $request->get('soft_id');
        $draft->package_id = json_encode($request->get('package_id'));
        $draft->fear = intval($request->get('fear'));
        $draft->url = $request->get('url', '');
        $draft->progress = $request->get('progress', '');
        $draft->good_comment = $request->get('good_comment', '');
        $draft->bad_comment = $request->get('bad_comment', '');
        $draft->general_comment = $request->get('general_comment', '');
        $draft->is_spoiler = $request->get('is_spoiler', 0);
    }

    /**
     * 下書き削除
     *
     * @param int $softId
     * @param int $packageId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDraft($softId, $packageId)
    {
        $draft = Orm\ReviewDraft::getData(Auth::id(), $softId, $packageId);
        if ($draft) {
            $draft->delete();
        }

        return redirect()->back();
    }

    /**
     * レビューを編集
     *
     * @param Orm\Review $review
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Orm\Review $review)
    {
        if ($review->user_id != Auth::id()) {
            // 他のユーザーのデータを編集しようとしている
            App::abort(403);
        }

        return view('review.edit', [
            'review'      => $review,
            'gamePackage' => Orm\GamePackage::find($review->package_id)
        ]);
    }

    /**
     * データの修正
     *
     * @param WriteRequest $request
     * @param Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(WriteRequest $request, Orm\Review $review)
    {
        if ($review->user_id != Auth::id()) {
            // 他のユーザーのデータを編集しようとしている
            App::abort(403);
        }

        $review->title = $request->get('title') ?? '';
        $review->fear = intval($request->get('fear') ?? 3);
        $review->story = intval($request->get('story') ?? 3);
        $review->volume = intval($request->get('volume') ?? 3);
        $review->difficulty = intval($request->get('difficulty') ?? 3);
        $review->graphic = intval($request->get('graphic') ?? 3);
        $review->sound = intval($request->get('sound') ?? 3);
        $review->crowded = intval($request->get('crowded') ?? 3);
        $review->controllability = intval($request->get('controllability') ?? 3);
        $review->recommend = intval($request->get('recommend') ?? 3);
        $review->progress = $request->get('progress') ?? '';
        $review->text = $request->get('text') ?? '';
        $review->is_spoiler = $request->get('is_spoiler') ?? 0;
        $review->calcPoint();

        $review->save();

        return redirect('review/detail/' . $review->id);
    }

    /**
     * データ削除
     *
     * @param Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Orm\Review $review)
    {
        if ($review->user_id != Auth::id()) {
            // 他のユーザーのデータを削除しようとしている
            App::abort(403);
        }

        // TODO とりあえず削除
        // β版では論理削除とデータのクリアにして、ID自体は残すようにする
        $review->delete();

        return redirect('review/game/' . $review->soft_id);
    }

    /**
     * 詳細
     *
     * @param Orm\Review $review
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Orm\Review $review)
    {
        $soft = Orm\GameSoft::find($review->soft_id);

        $r = new Review();

        // 投稿者本人か
        $isWriter = $review->user_id == Auth::id();

        // いいね済みか
        $hasGood = false;
        if (!$isWriter) {
            $hasGood = $r->hasGood($review->id, Auth::id());
        }

        return view('review.detail', [
            'soft'     => $soft,
            'package'  => Orm\GamePackage::find($review->package_id),
            'review'   => $review,
            'isWriter' => $isWriter,
            'hasGood'  => $hasGood,
            'user'     => User::find($review->user_id)
        ]);
    }

    /**
     * 新着
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newArrivals()
    {
        $reviews = Orm\Review::orderBy('id', 'desc')
            ->paginate(20);

        return view('review.newArrivals', [
            'reviews'      => $reviews,
            'writers'      => User::getHash(array_pluck($reviews->items(), 'user_id')),
            'gamePackages' => Orm\GamePackage::getHash(array_pluck($reviews->items(), 'package_id'))
        ]);
    }
}
