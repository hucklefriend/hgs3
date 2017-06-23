<?php

namespace Hgs3\Http\Controllers\Master;

use Hgs3\Models\Orm\GamePlatform;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;

class GamePlatformController extends Controller
{
    public function index()
    {
        $platforms = GamePlatform::All();

        return view('master.game_platform.list')->with([
            "list"   => $platforms
        ]);
    }

    public function create()
    {
        return view('master.game_platform.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gamePlatform = new GamePlatform;
        $gamePlatform->name = $request->input('name');
        $gamePlatform->acronym = $request->input('acronym');
        $gamePlatform->sort_order = $request->input('sort_order');

        $gamePlatform->save();

        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  \AppModels\Orm\GamePlatform  $gamePlatform
     * @return \Illuminate\Http\Response
     */
    public function show(GamePlatform $gamePlatform)
    {
        return view('master.game_platform.detail')->with([
            'gamePlatform' => $gamePlatform
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AppModels\Orm\GamePlatform  $gamePlatform
     * @return \Illuminate\Http\Response
     */
    public function edit(GamePlatform $gamePlatform)
    {
        return view('master.game_platform.edit')->with([
            'gamePlatform' => $gamePlatform
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \AppModels\Orm\GamePlatform  $gamePlatform
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GamePlatform $gamePlatform)
    {
        $gamePlatform->name = $request->input('name');
        $gamePlatform->acronym = $request->input('acronym');
        $gamePlatform->sort_order = $request->input('sort_order');

        $gamePlatform->save();

        return $this->edit($gamePlatform);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Hgs3\Models\Orm\GamePlatform  $gamePlatform
     * @return \Illuminate\Http\Response
     */
    public function destroy(GamePlatform $gamePlatform)
    {
        $gamePlatform->delete();

        return $this->index();
    }
}
