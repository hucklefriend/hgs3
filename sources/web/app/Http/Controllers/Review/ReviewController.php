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
    public function soft(Game $game)
    {
        // TODO 発売日が過ぎていないと投稿するリンクは出さない

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
            'game'     => $game,
            'packages' => $review->getPackageList($game->id),
            'drafts'   => ReviewDraft::getHashByGame(Auth::id(), $game->id),
            'written'  => \Hgs3\Models\Orm\Review::getHashByGame(Auth::id(), $game->id)
        ]);

    }

    /**
     * 入力画面
     *
     * @param GamePackage $pkg
     * @return $this
     */
    public function input(GamePackage $gamePackage)
    {
        // TODO 下書きがあるかチェック
        // TODO 同一ソフトのパッケージがあればその旨出力
        // TODO 同一ソフトの他パッケージの内容コピー
        // TODO 発売日が過ぎているか

        $isDraft = false;
        if (!empty(old())) {
            $draft = new ReviewDraft(old());
        } else {
            $draft = ReviewDraft::where('user_id', Auth::id())
                ->where('package_id', $gamePackage->id)
                ->first();
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
            $draft = ReviewDraft::find(Auth::id());
            if ($draft === null) {
                $draft = new ReviewDraft;
            }

            $this->setDraftData($request, $draft);
            $draft->game_id = $gamePackage->game_id;
            $draft->package_id = $gamePackage->id;
            $draft->save();

            return view('review.saveDraft')->with([
                'gameId' => $draft->game_id
            ]);
        } else {
            // レビュー投稿
            $review = new Review();
            $result = $review->save($request);

            return view('review.complete', [
                'reviewId'    => $result,
                'gamePackage' => $gamePackage
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
        $draft->fear = $request->get('fear') ?? 3;
        $draft->story = $request->get('story') ?? 3;
        $draft->volume = $request->get('volume') ?? 3;
        $draft->difficulty = $request->get('difficulty') ?? 3;
        $draft->graphic = $request->get('graphic') ?? 3;
        $draft->sound = $request->get('sound') ?? 3;
        $draft->crowded = $request->get('crowded') ?? 3;
        $draft->controllability = $request->get('controllability') ?? 3;
        $draft->recommend = $request->get('recommend') ?? 3;
        $draft->progress = $request->get('progress') ?? '';
        $draft->text = $request->get('text') ?? '';
        $draft->is_spoiler = $request->get('is_spoiler') ?? 0;
        $draft->calcPoint();
    }

    /**
     * いいね
     *
     * @param \Hgs3\Models\Orm\Review $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function good(\Hgs3\Models\Orm\Review $review)
    {
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
    public function cancelGood(\Hgs3\Models\Orm\Review $review)
    {
        $r = new Review();
        if ($r->hasGood($review->id, Auth::id())) {
            $r->cancelGood($review, Auth::id());
        }

        return redirect()->back();
    }

    /**
     * 詳細
     *
     * @param \Hgs3\Models\Orm\Review $review
     */
    public function show(\Hgs3\Models\Orm\Review $review)
    {
        // TODO レビュー存在しない

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
     * いいね履歴
     *
     * @param \Hgs3\Models\Orm\Review $review
     */
    public function goodHistory(\Hgs3\Models\Orm\Review $review)
    {
        // TODO 投稿者本人しか見られない

        $r = new Review;
        $his = $r->getGoodHistory($review->id);
        $users = [];
        if (!empty($his)) {
            $users = User::getNameHash(array_pluck($his, 'user_id'));
        }

        return view('review.good_history')->with([
            'review'    => $review,
            'histories' => $his,
            'users'     => $users
        ]);
    }
}
