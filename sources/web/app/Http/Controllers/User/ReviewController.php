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
        return view('user.review.index');
    }

    /**
     * 入力画面
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function input(Orm\GameSoft $soft)
    {
        // TODO 公開済みのレビューかチェック

        // 下書きを取得
        $draft = Orm\ReviewDraft::getData(Auth::id(), $soft->id);

        return view('user.review.input', [
            'soft'     => $soft,
            'packages' => $soft->getPackages(),
            'draft'    => $draft,
        ]);
    }

    /**
     * 保存
     *
     * @param WriteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function save(WriteRequest $request)
    {
        // TODO 公開済みのレビューかチェック

        $draft = Orm\ReviewDraft::getData(Auth::id(), $request->get('soft_id'));
        $this->setDraftData($request, $draft);

        Review::saveDraft($draft, $request->get('good_tags', []), $request->get('very_good_tags', []),
            $request->get('bad_tags', []), $request->get('very_bad_tags', []));

        return redirect()->route('レビュー投稿確認', ['soft' => $draft->soft_id]);
    }

    /**
     * 確認
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm(Orm\GameSoft $soft)
    {
        // TODO 公開済みのレビューかチェック

        $draft = Orm\ReviewDraft::getData(Auth::id(), $soft->id);

        if ($draft->isDefault) {
            session(['nothing_draft_message' => 1]);
            return redirect()->route('プロフィール2', ['user' => Auth::user()->show_id, 'show' => 'review']);
        } else {
            return view('user.review.confirm', [
                'soft'      => $soft,
                'package'   => $soft->originalPackage(),
                'user'      => Auth::user(),
                'draft'     => $draft,
                'packages'  => $draft->getPackages()
            ]);
        }
    }

    /**
     * 下書きを公開
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function open(Orm\GameSoft $soft)
    {
        // TODO 公開済みのレビューかチェック

        $draft = Orm\ReviewDraft::getData(Auth::id(), $soft->id);

        if ($draft->isDefault) {
        } else {
            Review::open($soft, $draft);
            return redirect()->route('プロフィール2', ['user' => Auth::user()->show_id, 'show' => 'review']);
        }
    }

    /**
     * 下書きモデルに値をセット
     *
     * @param WriteRequest $request
     * @param Orm\ReviewDraft $draft
     */
    private function setDraftData(WriteRequest $request, Orm\ReviewDraft $draft)
    {
        $draft->package_id = json_encode($request->get('package_id', []));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDraft($softId)
    {
        $draft = Orm\ReviewDraft::getData(Auth::id(), $softId);
        if (!$draft->isDefault) {
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

        $review->delete();

        return redirect()->route('ユーザーのレビュー');
    }
}
