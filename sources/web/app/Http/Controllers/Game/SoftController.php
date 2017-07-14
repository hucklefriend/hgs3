<?php
namespace Hgs3\Http\Controllers\Game;

use Hgs3\Constants\PhoneticType;
use Hgs3\Constants\UserRole;
use Hgs3\Http\Requests\Game\Soft\AddPackageRequest;
use Hgs3\Http\Requests\Game\Soft\UpdateRequest;
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

    public function edit(Game $game)
    {
        return view('game.soft.edit')->with([
            'game' => $game
        ]);
    }

    public function update(UpdateRequest $request, Game $game)
    {
        $game->name = $request->get('name');
        $game->phonetic = $request->get('phonetic', '');
        $game->phonetic_type = PhoneticType::getTypeByPhonetic($game->phonetic);
        $game->phonetic_order = $request->get('phonetic_order');
        $game->genre = $request->get('genre') ?? '';
        $game->company_id = $request->get('company_id');
        $game->series_id = $request->get('series_id');
        $game->order_in_series = $request->get('order_in_series');
        $game->game_type = $request->get('game_type');

        $game->save();

        return redirect('game/soft/' . $game->id);
    }

    public function addPackage(Game $game)
    {

    }

    public function storePackage(AddPackageRequest $request, Game $game)
    {

    }

    public function editPackage()
    {

    }

    public function remove(Game $game)
    {
    }
}
