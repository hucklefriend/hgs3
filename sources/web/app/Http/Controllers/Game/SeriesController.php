<?php
/**
 * シリーズコントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Http\Requests\Game\GameSeriesRequest;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\GameSeries;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SeriesController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'game');
    }

    /**
     * シリーズ一覧
     *
     * @return $this
     */
    public function index()
    {
        return view('game.series.index', [
            'series' => GameSeries::orderBy('phonetic')->paginate(20)
        ]);
    }

    /**
     * シリーズ詳細
     *
     * @param GameSeries $gameSeries
     * @return $this
     */
    public function show(GameSeries $gameSeries)
    {
        return view('game.series.detail')->with([
            'gameSeries' => $gameSeries,
            'games'      => Game::where('series_id', $gameSeries->id)->get()
        ]);
    }

    /**
     * データ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('game.series.add');
    }

    /**
     * データ追加
     *
     * @param GameSeriesRequest $request
     * @return SeriesController
     */
    public function insert(GameSeriesRequest $request)
    {
        $gameSeries = new GameSeries;
        $gameSeries->name = $request->input('name', '');
        $gameSeries->phonetic = $request->input('phonetic', '');

        $gameSeries->save();

        if (Input::get('from') == 'game_add') {
            return redirect('game/soft/add');
        } else {
            return redirect('game/series/' . $gameSeries->id);
        }
    }

    /**
     * データ編集
     *
     * @param GameSeries $gameSeries
     * @return $this
     */
    public function edit(GameSeries $gameSeries)
    {
        return view('game.series.edit')->with([
            'gameSeries' => $gameSeries
        ]);
    }

    /**
     * データ更新
     *
     * @param GameSeriesRequest $request
     * @param GameSeries $gameSeries
     * @return SeriesController
     */
    public function update(GameSeriesRequest $request, GameSeries $gameSeries)
    {
        $gameSeries->name = $request->input('name');
        $gameSeries->phonetic = $request->input('phonetic');

        $gameSeries->save();

        return redirect('game/series/detail/' . $gameSeries->id);
    }
}
