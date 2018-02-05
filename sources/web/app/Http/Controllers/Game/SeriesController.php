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
    public function detail(Orm\GameSeries $series)
    {
        return view('game.series.detail', [
            'gameSeries' => $series,
            'gameSofts'  => Orm\GameSoft::where('series_id', $series->id)->get()
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
        $series = new Orm\GameSeries;
        $series->name = $request->input('name', '');
        $series->phonetic = $request->input('phonetic', '');

        $series->save();

        if (Input::get('from') == 'game_add') {
            return redirect()->route('ゲームソフト登録');
        } else {
            return redirect()->route('シリーズ詳細', ['series' => $series->id]);
        }
    }

    /**
     * シリーズ編集画面
     *
     * @param Orm\GameSeries $gameSeries
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Orm\GameSeries $series)
    {
        return view('game.series.edit', [
            'series' => $series
        ]);
    }

    /**
     * データ更新
     *
     * @param GameSeriesRequest $request
     * @param Orm\GameSeries $gameSeries
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(GameSeriesRequest $request, Orm\GameSeries $series)
    {
        $series->name = $request->input('name');
        $series->phonetic = $request->input('phonetic');

        $series->save();

        return redirect()->route('シリーズ詳細', ['series' => $series->id]);
    }
}
