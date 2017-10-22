<?php
/**
 * 遊んだプレーヤーコントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Hgs3\Http\Controllers\Controller;

class PlayedUserController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'game');
    }

    /**
     * 遊んだゲームに登録しているユーザー
     *
     * @param Orm\GameSoft $gameSoft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Orm\GameSoft $gameSoft)
    {
        $userPlayedSofts = Orm\UserPlayedSoft::where('soft_id', $gameSoft->id)
            ->paginate(30);

        return view('game.played.index', [
            'gameSoft'        => $gameSoft,
            'userPlayedSofts' => $userPlayedSofts,
            'users'           => User::getNameHash(array_pluck($userPlayedSofts->items(), 'user_id'))
        ]);
    }
}
