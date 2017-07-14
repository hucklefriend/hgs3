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
    public function add(Game $game)
    {

    }

    public function store(StoreRequest $request, Game $game)
    {

    }

    public function edit(GamePackage $pkg)
    {

    }

    public function update(UpdateRequest $request, GamePackage $pkg)
    {

    }

    public function remove(GamePackage $pkg)
    {
    }
}
