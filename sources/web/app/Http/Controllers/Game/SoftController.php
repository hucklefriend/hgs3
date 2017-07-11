<?php
namespace Hgs3\Http\Controllers\Game;

use Hgs3\Constants\PhoneticType;
use Hgs3\Constants\UserRole;
use Hgs3\Models\Orm\GameComment;
use Hgs3\Models\Orm\GamePlatform;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\Orm\Game;
use Illuminate\Support\Facades\Auth;

class SoftController extends Controller
{
    public function index()
    {
        $soft = new Soft;

        return view('game.soft.list')->with([
            'phoneticList' => PhoneticType::getId2CharData(),
            'list'         => $soft->getList(),
        ]);
    }

    public function show(Game $game)
    {
        $soft = new Soft;

        return view('game.soft.detail')->with([
            'soft' => $soft->getDetail($game),
            'isUser' => UserRole::isUser(),
            'isAdmin' => UserRole::isAdmin(),
        ]);
    }

    public function comment(Game $game)
    {

    }

    public function writeComment(Request $req, Game $game)
    {
        $comment = new GameComment;
        $comment->game_id = $game->id;
        $comment->user_id = Auth::id();
        $comment->type = intval($req->input('type', 0));
        $comment->comment = $req->input('comment', '');

        $comment->save();
        return redirect()->back();
    }

    public function showAddForm()
    {
        return view('game.soft.add');
    }

    public function edit(Game $game)
    {
    }

    public function update(Game $game)
    {
    }

    public function remove(Game $game)
    {
    }
}
