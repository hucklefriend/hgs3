<?php
/**
 * レビューコントローラ
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Constants\InjusticeStatus;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Game\Review\InputRequest;
use Hgs3\Models\Game\Review;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\GamePackage;
use Hgs3\Models\Orm\InjusticeReview;
use Hgs3\Models\Orm\ReviewDraft;
use Hgs3\Models\Orm\ReviewTotal;
use Hgs3\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

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
        return view('game.review.index')->with([
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
            //$pager->setPath('game/review/soft/' . $game->id);
            $pager->setPath('');

            $data['pager'] = $pager;
        }

        return view('game.review.soft', $data);
    }

    /**
     * 入力画面
     *
     * @param Game $game
     */
    public function input(Game $game)
    {
        // TODO 下書きがあるかチェック
        // TODO 同一ソフトのパッケージがあればその旨出力
        // TODO 同一ソフトの他パッケージの内容コピー

        $pkg = GamePackage::where('game_id', $game->id)
            ->orderBy('release_int')
            ->get();

        if (Input::get('back', 0) == 1 && !empty(old())) {
            $draft = new ReviewDraft(old());
        } else {
            $review = new Review;
            $draft = $review->getDraft(Auth::id(), $game->id);
            if (!empty($pkg)) {
                $draft->package_id = $pkg[0]->id;
            }
        }

        return view('game.review.input')->with([
            'game'     => $game,
            'packages' => $pkg,
            'draft'    => $draft
        ]);
    }

    /**
     * 確認
     *
     * @param Game $game
     */
    public function confirm(InputRequest $request, Game $game)
    {
        $draft = new ReviewDraft;
        $this->setDraftData($request, $draft);

        return view('game.review.confirm')->with([
            'game'  => $game,
            'draft' => $draft
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
        $draftType = $request->get('draft');

        if ($draftType == -1) {
            // 入力画面に戻る
            return redirect('game/review/input/' . $game->id . '?back=1')->withInput();
        } if ($draftType == 1) {
            // 下書き保存
            $draft = ReviewDraft::find(Auth::id());
            if ($draft === null) {
                $draft = new ReviewDraft;
            }

            $this->setDraftData($request, $draft);
            $draft->save();

            return view('game.review.saveDraft')->with([
                'gameId' => $draft->game_id
            ]);
        } else {
            // レビュー投稿
            $review = new Review();
            $result = $review->save($request);

            return view('game.review.complete')->with([
                'reviewId' => $result,
                'game'     => $game
            ]);
        }
    }

    /**
     * 下書きモデルに値をセット
     *
     * @param InputRequest $request
     * @param ReviewDraft $draft
     */
    private function setDraftData(InputRequest $request, ReviewDraft $draft)
    {
        $draft->user_id = \Auth::id();
        $draft->game_id = $request->get('game_id');
        $draft->package_id = $request->get('package_id');
        $draft->play_time = $request->get('play_time') ?? 0;
        $draft->title = $request->get('title') ?? '';
        $draft->point = 0;
        $draft->fear = $request->get('fear') ?? 3;
        $draft->story = $request->get('story') ?? 3;
        $draft->volume = $request->get('volume') ?? 3;
        $draft->difficulty = $request->get('difficulty') ?? 3;
        $draft->graphic = $request->get('graphic') ?? 3;
        $draft->sound = $request->get('sound') ?? 3;
        $draft->crowded = $request->get('crowded') ?? 3;
        $draft->controllability = $request->get('controllability') ?? 3;
        $draft->recommend = $request->get('recommend') ?? 3;
        $draft->thoughts = $request->get('thoughts') ?? '';
        $draft->recommendatory = $request->get('recommendatory') ?? '';
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

        return view('game.review.detail')->with([
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

        return view('game.review.good_history')->with([
            'review'    => $review,
            'histories' => $his,
            'users'     => $users
        ]);
    }
}
