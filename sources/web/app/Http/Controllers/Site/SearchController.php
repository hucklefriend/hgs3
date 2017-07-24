<?php

namespace Hgs3\Http\Controllers\Site;

use Hgs3\Constants\UserRole;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Searcher;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\Site;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Arr;

class SearchController extends Controller
{
    /**
     * トップ
     *
     * @return $this
     */
    public function index()
    {
        $gameId = intval(Input::get('gid', 0));
        $mainContents = intval(Input::get('mc', 0));
        $targetGender = intval(Input::get('tg', 0));
        $rate = intval(Input::get('r', 0));

        $searcher = new Searcher();
        $data = $searcher->search($gameId, $mainContents, $targetGender, $rate, 20);

        return view('site.search.list')->with($data);
    }

    public function byGame(Game $game)
    {
        $mainContents = intval(Input::get('mc', 0));
        $targetGender = intval(Input::get('tg', 0));
        $rate = intval(Input::get('r', 0));
        $searcher = new Searcher();
        $data = $searcher->search($game->id, $mainContents, $targetGender, $rate, 20);
        $data['game'] = $game;

        return view('site.search.gameList')->with($data);
    }

    public function byUser($userId)
    {
        $sites = Site::where('user_id', $userId)
            ->orderBy('updated_timestamp', 'DESC')
            ->get();

        return view('site.search.userList')->with([
            'sites' => $sites
        ]);
    }

    public function show(Site $site)
    {
        $handleGames = [];

        $gameIds = $site->getHandleGames();
        if (!empty($gameIds)) {
            $handleGames = Game::getNameHash($gameIds);
        }

        return view('site.search.detail')->with([
            'site' => $site,
            'handleGames' => implode('、', $handleGames)
        ]);
    }

    public function good()
    {

    }

    public function injustice()
    {

    }
}
