<?php
/**
 * ゲームソフトコントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Constants\PhoneticType;
use Hgs3\Http\Requests\Game\GameSoftRequest;
use Hgs3\Models\Orm;
use Hgs3\Models\User\FavoriteGame;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Soft;
use Illuminate\Support\Facades\Auth;


class SoftController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'game');
    }

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
     * @param Orm\GameSoft $gameSoft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Orm\GameSoft $gameSoft)
    {
        // TODO 発売日が過ぎていないとレビューを投稿するリンクは出さない

        $soft = new Soft;
        $data = $soft->getDetail($gameSoft);

        if (Auth::check()) {
            $fav = new FavoriteGame();
            $data['isFavorite'] = $fav->isFavorite(Auth::id(), $game->id);
            $data['playedGame'] = UserPlayedSoft::findByUserAndGame(Auth::id(), $game->id);
        }

        $data['csrfToken'] = csrf_token();

        return view('game.soft.detail', $data);
    }

    /**
     * 追加フォーム
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('game.soft.add');
    }

    /**
     * 追加
     *
     * @param GameSoftRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function insert(GameSoftRequest $request)
    {
        $game = new GameSoft();

        $game->name = $request->get('name');
        $game->phonetic = $request->get('phonetic');
        $game->phonetic_type = PhoneticType::getTypeByPhonetic($game->phonetic);
        $game->phonetic_order = $request->get('phonetic');
        $game->genre = $request->get('genre', '');
        $game->company_id = $request->get('company_id', null);
        $game->series_id = $request->get('series_id', null);
        $game->order_in_series = $request->get('order_in_series', null);
        $game->game_type = 0;

        $game->save();

        return redirect('game/soft/' . $game->id);
    }

    /**
     * 編集画面
     *
     * @param GameSoft $game
     * @return $this
     */
    public function edit(GameSoft $game)
    {
        return view('game.soft.edit')->with([
            'game' => $game
        ]);
    }

    public function update(UpdateRequest $request, GameSoft $game)
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
