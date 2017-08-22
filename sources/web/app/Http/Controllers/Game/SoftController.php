<?php
/**
 * ゲームソフトコントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Constants\PhoneticType;
use Hgs3\Constants\UserRole;
use Hgs3\Http\Requests\Game\Soft\UpdateRequest;
use Hgs3\Models\Orm\GameComment;
use Hgs3\Models\Orm\UserPlayedGame;
use Hgs3\Models\User\FavoriteGame;
use Hgs3\Models\User\PlayedGame;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\Orm\Game;
use Illuminate\Support\Facades\Auth;

class SoftController extends Controller
{
    /**
     * 一覧ページ
     */
    public function index()
    {
        $soft = new Soft;

        return view('game.soft.index')->with([
            'phoneticList' => PhoneticType::getId2CharData(),
            'list'         => $soft->getList(),
        ]);
    }

    /**
     * 詳細ページ
     *
     * @param Game $game
     */
    public function show(Game $game)
    {
        $soft = new Soft;
        $data = $soft->getDetail($game);

        $data['isUser'] = UserRole::isUser();
        $data['isAdmin'] = UserRole::isAdmin();

        if ($data['isUser']) {
            $fav = new FavoriteGame();
            $data['isFavorite'] = $fav->isFavorite(Auth::id(), $game->id);
            $data['playedGame'] = UserPlayedGame::findByUserAndGame(Auth::id(), $game->id);
        }

        $data['csrfToken'] = csrf_token();

        return view('game.soft.detail')->with($data);
    }

    public function showAddForm()
    {
        return view('game.soft.add');
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
}
