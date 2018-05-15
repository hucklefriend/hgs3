<?php
/**
 * レビューコントローラ
 */

namespace Hgs3\Http\Controllers\Game;

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
     * レビュートップページ
     */
    public function index()
    {
        return view('review.index', Review::getTopPageData(5));
    }

    /**
     * 特定ゲームソフトのレビュー一覧
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function soft(Orm\GameSoft $soft)
    {
        $data = [
            'soft'  => $soft,
            'total' => null
        ];

        $total = Orm\ReviewTotal::find($soft->id);
        if ($total !== null) {
            $data['total'] = $total;
            $data['reviews'] = Review::getNewArrivalsBySoft($soft->id, 10);

            $pager = new LengthAwarePaginator([], $total->review_num, 10);
            $pager->setPath('');

            $data['pager'] = $pager;
        }

        return view('review.soft', $data);
    }

    /**
     * パッケージ選択
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function packageSelect(Orm\GameSoft $soft)
    {
        $review = new Review();
        $packages = $review->getPackageList($soft->id);

        return view('review.packageSelect', [
            'soft'     => $soft,
            'packages' => $packages,
            'shops'    => Package::getShopData(array_pluck($packages, 'id')),
            'drafts'   => Orm\ReviewDraft::getHashBySoft(Auth::id(), $soft->id),
            'written'  => Orm\Review::getHashBySoft(Auth::id(), $soft->id),
            'dateInt'  => $this->getDateInt()
        ]);
    }

    /**
     * 今日の日付のintを取得(yyyymmdd)
     *
     * @return int
     */
    private function getDateInt()
    {
        $dt = new \DateTime();
        return intval($dt->format('Ymd'));
    }

    /**
     * 入力画面
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function input(Orm\GameSoft $soft)
    {
        $packages = $soft->getPackages();

        $isDraft = false;
        if (!empty(old())) {
            $draft = new Orm\ReviewDraft(old());
        } else {
            $draft = Orm\ReviewDraft::getData(Auth::id(), $soft->id, $package->id);
            if ($draft == null) {
                $draft = Orm\ReviewDraft::getDefault(Auth::id(), $soft->id, $package->id);
            } else {
                $isDraft = true;
            }
        }

        return view('game.review.input', [
            'soft'    => $soft,
            'package' => $package,
            'draft'   => $draft,
            'isDraft' => $isDraft
        ]);
    }

    /**
     * 確認
     *
     * @param WriteRequest $request
     * @param Orm\GamePackage $package
     * @param Orm\gameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm(WriteRequest $request, Orm\gameSoft $soft, Orm\GamePackage $package)
    {
        $draft = new Orm\ReviewDraft;
        $this->setDraftData($request, $draft);

        return view('review.confirm', [
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
     * @param Orm\GameSoft $soft
     * @param Orm\GamePackage $package
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function save(WriteRequest $request, Orm\GameSoft $soft, Orm\GamePackage $package)
    {
        // TODO: 発売日が過ぎているか


        $draftType = $request->get('draft');

        if ($draftType == -1) {
            // 入力画面に戻る
            return redirect('review/write/' . $soft->id . '/' . $package->id)->withInput();
        } if ($draftType == 1) {
            // 下書き保存
            $draft = Orm\ReviewDraft::getData(Auth::id(), $soft->id, $package->id);
            if ($draft === null) {
                $draft = new Orm\ReviewDraft;
            }

            $this->setDraftData($request, $draft);
            $draft->soft_id = $soft->id;
            $draft->package_id = $package->id;
            $draft->save();

            return view('review.saveDraft', [
                'package' => $package,
                'soft'    => $soft
            ]);
        } else {
            // 下書きに保存
            $draft = new Orm\ReviewDraft;
            $this->setDraftData($request, $draft);
            $draft->soft_id = $package->soft_id;
            $draft->package_id = $package->id;

            // レビュー投稿
            $review = new Orm\Review($draft->toArray());
            $review->save();

            return view('review.complete', [
                'reviewId' => $review->id,
                'package'  => $package,
                'soft'     => $soft
            ]);
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
        $draft->user_id = \Auth::id();
        $draft->soft_id = $request->get('soft_id');
        $draft->package_id = $request->get('package_id');
        $draft->title = $request->get('title') ?? '';
        $draft->fear = intval($request->get('fear') ?? 3);
        $draft->story = intval($request->get('story') ?? 3);
        $draft->volume = intval($request->get('volume') ?? 3);
        $draft->difficulty = intval($request->get('difficulty') ?? 3);
        $draft->graphic = intval($request->get('graphic') ?? 3);
        $draft->sound = intval($request->get('sound') ?? 3);
        $draft->crowded = intval($request->get('crowded') ?? 3);
        $draft->controllability = intval($request->get('controllability') ?? 3);
        $draft->recommend = intval($request->get('recommend') ?? 3);
        $draft->progress = $request->get('progress') ?? '';
        $draft->text = $request->get('text') ?? '';
        $draft->is_spoiler = $request->get('is_spoiler') ?? 0;
        $draft->calcPoint();
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
