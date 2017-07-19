<?php
/**
 * レビューコントローラ
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Game\Review\InputRequest;
use Hgs3\Models\Game\Review;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\ReviewDraft;
use Hgs3\Models\Orm\ReviewTotal;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * レビュートップページ
     */
    public function index()
    {
        $review = new Review();

        return view('game.review.index')->with([
            'highScore'
        ]);
    }

    /**
     * 特定ゲームソフトのレビュー
     *
     * @param Game $game
     */
    public function soft(Game $game)
    {
        $review = new Review();

        return view('game.review.soft')->with([
            'game'    => $game,
            'total'   => ReviewTotal::find($game->id),
            'reviews' => $review->getNewArrivals($game->id, 10)
        ]);
    }

    /**
     * 入力画面
     *
     * @param Game $game
     */
    public function input(Game $game)
    {
        // 下書きがあるかチェック
        $review = new Review;

        return view('game.review.input')->with([
            'game'   => $game,
            'review' => $review->getDraft(Auth::id(), $game->id)
        ]);
    }

    public function postInput(InputRequest $request)
    {
        if ($request->get('draft') == 1) {
            return $this->saveDraft($request);
        } else {
            return redirect('game/review/confirm/' . $request->get('game_id', 0))->withInput();
        }
    }

    /**
     * 確認
     *
     * @param Game $game
     */
    public function confirm(Game $game)
    {
        return view('game.review.confirm')->with([
            'game' => $game,
        ]);
    }

    /**
     * 保存
     *
     * @param InputRequest $request
     * @param Game $game
     */
    public function save(InputRequest $request, Game $game)
    {
        if ($request->get('draft') == 1) {
            return $this->saveDraft($request);
        } else {
            $review = new Review();
            $result = $review->save($request);

            return view('game.review.complete')->with([
                'reviewId' => $result,
                'game'     => $game
            ]);
        }
    }

    /**
     * 下書き保存
     *
     * @param InputRequest $request
     */
    public function saveDraft(InputRequest $request)
    {
        // firstOrNewを使うとsaveで「Illegal offset type in isset or empty」と言われるので使わない
        // 複合キーのせいだと思われる
        $draft = ReviewDraft::where('user_id', \Auth::id())
            ->where('game_id', $request->get('game_id'))
            ->first();

        $isNew = false;
        if ($draft === null) {
            $isNew = true;
            $draft = new ReviewDraft;
        }

        $draft->user_id = \Auth::id();
        $draft->game_id = $request->get('game_id');
        $draft->package_id = '';
        $draft->play_time = $request->get('play_time') ?? 0;
        $draft->title = $request->get('title') ?? '';
        $draft->point = 0;
        $draft->fear = $request->get('fear') ?? 0;
        $draft->story = $request->get('story') ?? 0;
        $draft->volume = $request->get('volume') ?? 0;
        $draft->difficulty = $request->get('difficulty') ?? 0;
        $draft->graphic = $request->get('graphic') ?? 0;
        $draft->sound = $request->get('sound') ?? 0;
        $draft->crowded = $request->get('crowded') ?? 0;
        $draft->controllability = $request->get('controllability') ?? 0;
        $draft->recommend = $request->get('recommend') ?? 0;
        $draft->thoughts = $request->get('thoughts') ?? '';
        $draft->recommendatory = $request->get('recommendatory') ?? '';

        if ($isNew) {
            $draft->insert();
        } else {
            $draft->update();
        }

        return view('game.review.saveDraft')->with([
            'gameId' => $draft->game_id
        ]);
    }

    public function good(\Hgs3\Models\Orm\Review $review)
    {

    }

    public function show(Game $game, \Hgs3\Models\Orm\Review $review)
    {
        return view('game.review.detail')->with([
            'game'   => $game,
            'review' => $review
        ]);
    }
}
