<?php
/**
 * お気に入りゲームコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Models\User\FavoriteGame;
use Hgs3\User;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteGameController extends Controller
{
    /**
     * お気に入りゲームリスト
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $user)
    {

        return view('user.game.favorite');
    }

    /**
     * お気に入りゲームリスト(自分)
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myself()
    {
        return $this->index(Auth::user());
    }

    /**
     * お気に入りゲーム追加
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
        $gameId = $request->get('game_id');
        if ($gameId != null) {
            $fav = new FavoriteGame();
            $fav->add(Auth::id(), $gameId);
        }

        return redirect()->back();
    }

    /**
     * お気に入りゲーム削除
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        $gameId = $request->get('game_id');
        if ($gameId != null) {
            $fav = new FavoriteGame();
            $fav->remove(Auth::id(), $gameId);
        }

        return redirect()->back();
    }
}
