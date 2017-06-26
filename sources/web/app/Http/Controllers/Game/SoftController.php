<?php
namespace Hgs3\Http\Controllers\Game;

use Hgs3\Constants\PhoneticType;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\Orm\Game;

class SoftController extends Controller
{
    public function index()
    {
        $soft = new Soft;

        return view('game.soft.list')->with([
            'phoneticList' => PhoneticType::getId2CharData(),
            'list'         => $soft->getList(),
        ]);
    }

    public function show(Game $game)
    {
        $soft = new Soft;

        return view('game.soft.detail')->with([
            'soft' => $soft->getDetail($game)
        ]);
    }


    public function edit(Game $game)
    {
        // TODO: 管理権限のある人のみ
    }

    public function update(Game $game)
    {
        // TODO: 管理権限のある人のみ
    }

    public function remove(Game $game)
    {
        // TODO: 管理権限のある人のみ
    }
}
