<?php
namespace Hgs3\Http\Controllers\Game;

use Hgs3\Constants\PhoneticType;
use Hgs3\Constants\UserRole;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\GameAddRequest;
use Hgs3\Models\Orm\GamePlatform;
use Hgs3\Models\Orm\GameUpdateRequest;
use Hgs3\User;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function index()
    {
        $req = GameAddRequest::orderBy('id', 'desc')->paginate(30);
        $userHash = User::getNameHash(Arr::pluck($req, 'user_id'));

        return view('game.request.list')->with([
            'list' => $req,
            'userHash' => $userHash
        ]);
    }

    public function input()
    {
        return view('game.request.input', [
            'platforms' => GamePlatform::all()
        ]);
    }

    public function store(Request $request)
    {
        $gar = new GameAddRequest;
        $gar->user_id = Auth::id();
        $gar->name = $request->input('name');
        $gar->url = $request->input('url');
        $gar->platforms = json_encode($request->input('platform', array()));
        $gar->other = $request->input('other');
        $gar->status = 0;

        $gar->save();

        return view('game.request.complete');
    }

    public function show(GameAddRequest $gar)
    {
        return view('game.request.detail', [
            'gar'  => $gar,
            'user' => User::find($gar->user_id),
            'isAdmin' => UserRole::isAdmin()
        ]);
    }
}
