<?php
/**
 * お気に入りゲームコントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $favoriteUsers = Orm\UserFavoriteSoft::select(['user_id', DB::raw('UNIX_TIMESTAMP(created_at) AS register_timestamp')])
            ->where('soft_id', $soft->id)
            ->orderBy('id', 'DESC')
            ->paginate(20);

        $userIds = page_pluck($favoriteUsers, 'user_id');
        $followStatus = [];
        if (!empty($userIds) && Auth::check()) {
            $followStatus = User\Follow::getFollowStatus(Auth::id(), $userIds);
        }

        return view('game.favoriteSoft.index')->with([
            'soft'          => $soft,
            'favoriteUsers' => $favoriteUsers,
            'users'         => User::getHash($userIds),
            'followStatus'  => $followStatus
        ]);
    }
}
