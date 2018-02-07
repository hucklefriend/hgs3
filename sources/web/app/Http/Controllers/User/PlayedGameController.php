<?php
/**
 * 遊んだゲームコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Requests\User\PlayedGame\AddRequest;
use Hgs3\Http\Requests\User\PlayedGame\EditRequest;
use Hgs3\Models\Orm\GameSoft;
use Hgs3\Models\Orm\UserPlayedSoft;
use Hgs3\Models\User;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlayedGameController extends Controller
{
    /**
     * 遊んだゲームリスト
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $user)
    {
        $isMyself = $user->id == Auth::id();
        $played = DB::table('user_played_games')
            ->where('user_id', $user->id)
            ->paginate(20);

        return view('user.game.played')->with([
            'user'        => $user,
            'isMyself'    => $isMyself,
            'playedGames' => $played,
            'games'       => GameSoft::getNameHash(array_pluck($played->items(), 'game_id'))
        ]);
    }

    /**
     * 追加
     *
     * @param AddRequest $request
     * @param GameSoft $game
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(AddRequest $request, GameSoft $game)
    {
        $upg = new UserPlayedSoft;

        $upg->user_id = Auth::id();
        $upg->game_id = $game->id;
        $upg->comment = $request->get('comment', '');
        $upg->save();

        return redirect()->back();
    }

    /**
     * 編集
     *
     * @param EditRequest $request
     * @param UserPlayedSoft $upg
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(EditRequest $request, UserPlayedSoft $upg)
    {
        $upg->comment = $request->get('comment', '');
        $upg->save();

        return redirect()->back();
    }

    /**
     * 削除
     *
     * @param UserPlayedSoft $upg
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(UserPlayedSoft $upg)
    {
        if (Auth::id() == $upg->id) {
            $upg->delete();
        }

        return redirect()->back();
    }
}
