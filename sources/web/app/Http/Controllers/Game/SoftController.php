<?php
namespace App\Http\Controllers\Game;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Game\Soft;
use App\Models\Orm\Game;

class SoftController extends Controller
{
    public function index()
    {
        $soft = new Soft;

        return view('game.soft.list')->with([
            "list"   => $soft->get_list()
        ]);
    }

    public function show(Game $game)
    {
        return view('game.soft.detail')->with([
            'soft' => $game
        ]);
    }
}
