<?php
/**
 * お気に入りゲームコントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\UserFavoriteGame;
use Hgs3\User;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteGameController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'game');
    }

    /**
     * お気に入りゲームに登録しているユーザー
     *
     * @param Game $game
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Game $game)
    {
        $pager = UserFavoriteGame::where('game_id', $game->id)
            ->paginate(30);

        return view('game.favorite.index')->with([
            'game'  => $game,
            'pager' => $pager,
            'users' => User::getNameHash(array_pluck($pager->items(), 'user_id'))
        ]);
    }
}
