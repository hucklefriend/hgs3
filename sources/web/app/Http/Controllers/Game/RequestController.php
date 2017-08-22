<?php
/**
 * ゲーム追加リクエスト
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Constants\PhoneticType;
use Hgs3\Constants\UserRole;
use Hgs3\Http\Requests\Game\Request\AddRequest;
use Hgs3\Http\Requests\Game\Request\ChangeStatusRequest;
use Hgs3\Http\Requests\Game\Request\CommentRequest;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\GameRequest;
use Hgs3\Models\Orm\GameRequestComment;
use Hgs3\Models\Orm\GamePlatform;
use Hgs3\Models\Orm\GameUpdateRequest;
use Hgs3\User;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * 追加リクエスト一覧
     *
     * @return $this
     */
    public function index()
    {
        $req = GameRequest::orderBy('id', 'desc')->paginate(30);
        $userHash = User::getNameHash(Arr::pluck($req, 'user_id'));

        return view('game.request.index', [
            'list' => $req,
            'userHash' => $userHash
        ]);
    }

    public function input()
    {
        return view('game.request.input', [
            'platforms' => GamePlatform::all()
        ]);
    }

    public function store(AddRequest $request)
    {
        $gr = new GameRequest;
        $gr->user_id = Auth::id();
        $gr->name = $request->input('name');
        $gr->url = $request->input('url');
        $gr->platforms = json_encode($request->input('platform', array()));
        $gr->other = $request->input('other');
        $gr->status = 0;

        $gr->save();

        return view('game.request.complete');
    }

    /**
     * 詳細表示
     *
     * @param GameRequest $gr
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(GameRequest $gr)
    {
        $req = new \Hgs3\Models\Game\GameRequest();

        $comments = $req->getComment($gr->id);

        return view('game.request.detail', [
            'gr'        => $gr,
            'user'      => User::find($gr->user_id),
            'isAdmin'   => UserRole::isAdmin(),
            'comments'  => $comments,
            'users'     => User::getNameHashByPager($comments),
            'csrfToken' => csrf_token()
        ]);
    }

    /**
     * コメント書き込み
     *
     * @param CommentRequest $request
     * @param GameRequest $gr
     * @return \Illuminate\Http\RedirectResponse
     */
    public function writeComment(CommentRequest $request, GameRequest $gr)
    {
        $model = new \Hgs3\Models\Game\GameRequest();
        $model->writeComment($gr, Auth::id(), $request->get('comment'));

        return redirect()->back();
    }

    /**
     * コメントの削除
     *
     * @param GameRequest $gr
     * @param GameRequestComment $grc
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteComment(GameRequest $gr, GameRequestComment $grc)
    {
        if ($grc->user_id == Auth::id()) {
            $model = new \Hgs3\Models\Game\GameRequest();
            $model->deleteComment($gr, $grc);
        }

        return redirect()->back();
    }

    /**
     * ステータスの更新
     *
     * @param ChangeStatusRequest $request
     * @param GameRequest $gr
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus(ChangeStatusRequest $request, GameRequest $gr)
    {
        $status = $request->get('status');

        $gr->status = $status;
        $gr->save();

        return redirect()->back();
    }
}
