<?php
namespace Hgs3\Http\Controllers\Game;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Game\Package\StoreRequest;
use Hgs3\Http\Requests\Game\Soft\UpdateRequest;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\GamePackage;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'game');
    }

    public function add(Game $game)
    {
        return view('game.package.add')->with([
            'game' => $game
        ]);
    }

    public function store(StoreRequest $request, Game $game)
    {
        $pkg = new GamePackage;

        $pkg->game_id = $game->id;
        $pkg->platform_id = $request->get('platform_id');
        $pkg->company_id = $request->get('company_id');
        $pkg->name = $request->get('name') ?? '';
        $pkg->url = $request->get('url') ?? '';     // TODO: ない時はnullにする
        $pkg->release_date = $request->get('release_date') ?? '';       // TODO: ない時はnullにする
        $pkg->release_int = $request->get('release_int') ?? 0;
        $pkg->game_type_id = $request->get('game_type');

        // ASINを見てamazon情報を取得する

        $pkg->save();

        return redirect('game/soft/' . $game->id);
    }

    public function edit(Game $game, GamePackage $pkg)
    {
        return view('game.package.edit')->with([
            'game' => $game,
            'pkg'  => $pkg
        ]);
    }

    public function update(UpdateRequest $request, Game $game, GamePackage $pkg)
    {
        $pkg->platform_id = $request->get('platform_id');
        $pkg->company_id = $request->get('company_id');
        $pkg->name = $request->get('name') ?? '';
        $pkg->url = $request->get('url') ?? '';     // TODO: ない時はnullにする
        $pkg->release_date = $request->get('release_date') ?? '';       // TODO: ない時はnullにする
        $pkg->release_int = $request->get('release_int') ?? 0;
        $pkg->game_type_id = $request->get('game_type');

        $pkg->save();

        return redirect('game/soft/' . $game->id);
    }

    public function remove(GamePackage $pkg)
    {
        $gameId = $pkg->game_id;

        $pkg->delete();

        return redirect('game/soft/' . $gameId);
    }
}
