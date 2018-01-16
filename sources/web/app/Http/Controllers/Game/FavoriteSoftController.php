<?php
/**
 * お気に入りゲームコントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteSoftController extends Controller
{
    /**
     * お気に入りゲームに登録しているユーザー
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Orm\GameSoft $soft)
    {
        $favoriteUsers = Orm\UserFavoriteSoft::where('soft_id', $soft->id)
            ->paginate(20);

        return view('game.favoriteSoft.index')->with([
            'soft'          => $soft,
            'favoriteUsers' => $favoriteUsers,
            'users'         => User::getHash(array_pluck($favoriteUsers->items(), 'user_id'))
        ]);
    }
}
