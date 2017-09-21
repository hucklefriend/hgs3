<?php
/**
 * 遊んだプレーヤーコントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\UserPlayedGame;
use Hgs3\User;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PlayedUserController extends Controller
{
    /**
     * 遊んだゲームに登録しているユーザー
     *
     * @param Game $game
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Game $game)
    {
        $pager = UserPlayedGame::where('game_id', $game->id)
            ->paginate(30);

        return view('game.played.index')->with([
            'game' => $game,
            'pager' => $pager,
            'users' => User::getNameHash(array_pluck($pager->items(), 'user_id'))
        ]);
    }
}