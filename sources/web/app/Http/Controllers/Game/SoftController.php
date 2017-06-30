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
        $comments = GameComment::where('game_id')
            ->orderBy('id', 'DESC')
            ->take(10)
            ->get();

        return view('game.soft.detail')->with([
            'soft' => $soft->getDetail($game),
            'comments' => $comments,
            'isUser' => UserRole::isUser(),
            'isAdmin' => UserRole::isAdmin(),
        ]);
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
