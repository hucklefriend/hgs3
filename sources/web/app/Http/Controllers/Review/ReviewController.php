<?php
/**
 * レビューコントローラ
 */

namespace Hgs3\Http\Controllers\Review;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Review\WriteRequest;
use Hgs3\Models\Review\Review;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\GamePackage;
use Hgs3\Models\Orm\ReviewDraft;
use Hgs3\Models\Orm\ReviewTotal;
use Hgs3\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
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
     * レビュートップページ
     */
    public function index()
    {
        $review = new Review();
        return view('review.index')->with([
            'newArrival' => $review->getNewArrivalsAll(5),
            'highScore'  => $review->getHighScore(5),
            'manyGood'   => $review->getManyGood(5)
        ]);
    }

    /**
     * 特定ゲームソフトのレビュー
     *
     * @param Game $game
     */
    public function game(Game $game)
    {
        $data = [
            'game'  => $game,
            'total' => null
        ];

        $review = new Review();

        $total = ReviewTotal::find($game->id);
        if ($total !== null) {
            $data['total'] = $total;

            $data['reviews'] = $review->getNewArrivals($game->id, 10);

            $pager = new LengthAwarePaginator([], $total->review_num, 10);
            $pager->setPath('');

            $data['pager'] = $pager;
        }

        return view('review.soft', $data);
    }

    /**
     * パッケージ選択
     *
     * @param Game $game
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function packageSelect(Game $game)
    {
        $review = new \Hgs3\Models\Review\Review();

        return view('review.packageSelect', [
            'game'      => $game,
            'packages'  => $review->getPackageList($game->id),
            'drafts'    => ReviewDraft::getHashByGame(Auth::id(), $game->id),
            'written'   => \Hgs3\Models\Orm\Review::getHashByGame(Auth::id(), $game->id),
            'csrfToken' => csrf_token(),
            'dateInt'   => $this->getDateInt()
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
     * @param GamePackage $pkg
     * @return $this
     */
    public function input(GamePackage $gamePackage)
    {
        // 発売日が過ぎていないパッケージ
        if ($gamePackage->release_int > $this->getDateInt()) {
            App::abort(404);
        }

        $isDraft = false;
        if (!empty(old())) {
            $draft = new ReviewDraft(old());
        } else {
            $draft = ReviewDraft::getData(Auth::id(), $gamePackage->id);
            if ($draft == null) {
                $draft = ReviewDraft::getDefault(Auth::id(), $gamePackage->game_id);
            } else {
                $isDraft = true;
            }
        }

        return view('review.input')->with([
            'gamePackage' => $gamePackage,
            'draft'       => $draft,
            'isDraft'     => $isDraft
        ]);
    }

    /**
     * 確認
     *
     * @param WriteRequest $request
     * @param GamePackage $gamePackage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm(WriteRequest $request, GamePackage $gamePackage)
    {
        $draft = new ReviewDraft;
        $this->setDraftData($request, $draft);

        return view('review.confirm', [
            'gamePackage' => $gamePackage,
            'user'        => Auth::user(),
            'draft'       => $draft
        ]);
    }

    /**
     * 保存
     *
     * @param WriteRequest $request
     * @param GamePackage $gamePackage
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function save(WriteRequest $request, GamePackage $gamePackage)
    {
        // TODO: 発売日が過ぎているか


        $draftType = $request->get('draft');

        if ($draftType == -1) {
            // 入力画面に戻る
            return redirect('review/write/' . $gamePackage->id)->withInput();
        } if ($draftType == 1) {
            // 下書き保存
            $draft = ReviewDraft::getData(Auth::id(), $gamePackage->id);
            if ($draft === null) {
                $draft = new ReviewDraft;
            }

            $this->setDraftData($request, $draft);
            $draft->game_id = $gamePackage->game_id;
            $draft->package_id = $gamePackage->id;
            $draft->save();

            return view('review.saveDraft', [
                'gamePackage' => $gamePackage,
                'game'        => Game::find($gamePackage->game_id)
            ]);
        } else {
            // 下書きに保存
            $draft = new ReviewDraft;
            $this->setDraftData($request, $draft);
            $draft->game_id = $gamePackage->game_id;
            $draft->package_id = $gamePackage->id;

            // レビュー投稿
            $review = new \Hgs3\Models\Orm\Review($draft->toArray());
            $review->save();

            return view('review.complete', [
                'reviewId'    => $review->id,
                'gamePackage' => $gamePackage,
                'game'        => Game::find($gamePackage->game_id)
            ]);
        }
    }

    /**
     * 下書きモデルに値をセット
     *
     * @param WriteRequest $request
     * @param ReviewDraft $draft
     */
    private function setDraftData(WriteRequest $request, ReviewDraft $draft)
    {
        $draft->user_id = \Auth::id();
        $draft->game_id = $request->get('game_id');
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
     * @param $packageId
     */
    public function deleteDraft($packageId)
    {
        $draft = ReviewDraft::getData(Auth::id(), $packageId);
        if ($draft) {
            $draft->delete();
        }

        return redirect()->back();
    }

    /**
     * レビューを編集
     *
     * @param \Hgs3\Models\Orm\Review $review
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(\Hgs3\Models\Orm\Review $review)
    {
        if ($review->user_id != Auth::id()) {
            // 他のユーザーのデータを編集しようとしている
            App::abort(403);
        }

        return view('review.edit', [
            'review'      => $review,
            'gamePackage' => GamePackage::find($review->package_id),
            'csrfToken'   => csrf_token()
        ]);
    }

    /**
     * データの修正
     *
     * @param WriteRequest $request
     * @param \Hgs3\Models\Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(WriteRequest $request, \Hgs3\Models\Orm\Review $review)
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
     * @param \Hgs3\Models\Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(\Hgs3\Models\Orm\Review $review)
    {
        if ($review->user_id != Auth::id()) {
            // 他のユーザーのデータを削除しようとしている
            App::abort(403);
        }

        // TODO とりあえず削除
        // β版では論理削除とデータのクリアにして、ID自体は残すようにする
        $review->delete();

        return redirect('review/game/' . $review->game_id);
    }

    /**
     * 詳細
     *
     * @param \Hgs3\Models\Orm\Review $review
     */
    public function show(\Hgs3\Models\Orm\Review $review)
    {
        $game = Game::find($review->game_id);

        $r = new Review();

        // 投稿者本人か
        $isWriter = $review->user_id == Auth::id();

        // いいね済みか
        $hasGood = false;
        if (!$isWriter) {
            $hasGood = $r->hasGood($review->id, Auth::id());
        }

        return view('review.detail', [
            'game'      => $game,
            'pkg'       => GamePackage::find($review->package_id),
            'review'    => $review,
            'isWriter'  => $isWriter,
            'hasGood'   => $hasGood,
            'user'      => User::find($review->user_id),
            'csrfToken' => csrf_token()
        ]);
    }

    /**
     * 新着
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newArrivals()
    {
        $reviews = \Hgs3\Models\Orm\Review::orderBy('id', 'desc')
            ->paginate(20);

        return view('review.newArrivals', [
            'reviews'      => $reviews,
            'writers'      => User::getHash(array_pluck($reviews->items(), 'user_id')),
            'gamePackages' => GamePackage::getHash(array_pluck($reviews->items(), 'package_id'))
        ]);
    }
}
