<?php
/**
 * シリーズコントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Http\Requests\Game\GameSeriesRequest;
use Hgs3\Models\Orm;
use Hgs3\Http\Controllers\Controller;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('game.series.index', [
            'series' => Orm\GameSeries::orderBy('phonetic')->paginate(20)
        ]);
    }

    /**
     * シリーズ詳細
     *
     * @param Orm\GameSeries $gameSeries
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Orm\GameSeries $gameSeries)
    {
        return view('game.series.detail', [
            'gameSeries' => $gameSeries,
            'gameSofts'  => Orm\GameSoft::where('series_id', $gameSeries->id)->get()
        ]);
    }

    /**
     * シリーズ追加画面
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
        $gameSeries = new Orm\GameSeries;
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
     * シリーズ編集画面
     *
     * @param Orm\GameSeries $gameSeries
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Orm\GameSeries $gameSeries)
    {
        return view('game.series.edit', [
            'gameSeries' => $gameSeries
        ]);
    }

    /**
     * データ更新
     *
     * @param GameSeriesRequest $request
     * @param Orm\GameSeries $gameSeries
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(GameSeriesRequest $request, Orm\GameSeries $gameSeries)
    {
        $gameSeries->name = $request->input('name');
        $gameSeries->phonetic = $request->input('phonetic');

        $gameSeries->save();

        return redirect('game/series/detail/' . $gameSeries->id);
    }
}
