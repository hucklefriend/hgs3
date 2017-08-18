<?php
/**
 * 遊んだゲームコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Requests\User\PlayedGame\AddRequest;
use Hgs3\Http\Requests\User\PlayedGame\EditRequest;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\UserPlayedGame;
use Hgs3\User;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PlayedGameController extends Controller
{
    /**
     * 追加
     *
     * @param AddRequest $request
     * @param Game $game
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(AddRequest $request, Game $game)
    {
        $upg = new UserPlayedGame;

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
     * @param UserPlayedGame $upg
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(EditRequest $request, UserPlayedGame $upg)
    {
        $upg->comment = $request->get('comment', '');
        $upg->save();

        return redirect()->back();
    }

    /**
     * 削除
     *
     * @param UserPlayedGame $upg
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(UserPlayedGame $upg)
    {
        if (Auth::id() == $upg->id) {
            $upg->delete();
        }

        return redirect()->back();
    }
}
