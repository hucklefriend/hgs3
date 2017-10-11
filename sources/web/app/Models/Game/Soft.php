<?php
/**
 * ゲームソフトモデル
 */

namespace Hgs3\Models\Game;

use Hgs3\Constants\PhoneticType;
use Hgs3\Http\Requests\Game\Soft\AddRequest;
use Hgs3\Models\Orm\GameCompany;
use Hgs3\Models\Orm\GamePackage;
use Hgs3\Models\Orm\ReviewTotal;
use Hgs3\Models\Orm\SiteHandleGame;
use Hgs3\Models\Orm\UserFavoriteGame;
use Hgs3\Models\Timeline;
use Hgs3\User;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\GameSeries;
use Illuminate\Support\Facades\Log;

class Soft
{
    /**
     * 一覧用データ取得
     *
     * @return array
     */
    public function getList()
    {
        $tmp = DB::table('games')
            ->select('id', 'name', 'phonetic_type')
            ->orderBy('phonetic_type', 'asc')
            ->orderBy('phonetic_order', 'asc')
            ->get();

        $result = array();
        foreach ($tmp as $game) {
            $result[$game->phonetic_type][] = $game;
        }

        return $result;
    }

    /**
     * 詳細データ取得
     *
     * @param Game $game
     * @return array
     */
    public function getDetail(Game $game)
    {
        $data = [];
        $data['game'] = $game;

        // シリーズ
        if ($game->series_id != null) {
            $data['series'] = $this->getDetailSeries($game->id, $game->series_id);
        } else {
            $data['series'] = null;
        }

        // メーカー
        // パッケージのメーカーを使うので不要
/*
        if ($game->company_id != null) {
            $data['company'] = GameCompany::find($game->company_id);
        } else {
            $data['company'] = null;
        }
*/
        // パッケージ情報
        $data['packages'] = $this->getDetailPackages($game->id);
        $data['package_num'] = count($data['packages']);

        // レビュー
        $data['review'] = ReviewTotal::find($game->id);

        // ベースデータ
        $data['base'] = $this->getBaseData($game);

        // お気に入り登録ユーザー
        $data['favorite'] = $this->getFavoriteUser($game);

        // サイト
        $data['site'] = $this->getSite($game);

        // コミュニティ


        // 遊んだゲーム
        $data['playedUsers'] = $this->getPlayedUsers($game);

        return $data;
    }

    /**
     * 同一シリーズのソフトを取得
     *
     * @param $gameId
     * @param $seriesId
     * @return array
     */
    private function getDetailSeries($gameId, $seriesId)
    {
        $series = GameSeries::find($seriesId);

        $data = array(
            'name' => $series->name
        );

        $data['list'] = DB::table('games')
            ->where('series_id', $seriesId)
            ->where('id', '<>', $gameId)
            ->get();

        return $data;
    }

    /**
     * パッケージの一覧を取得
     *
     * @param $gameId
     * @return array
     */
    private function getDetailPackages($gameId)
    {
        $sql =<<< SQL
SELECT pkg.*, plt.id plt_id, plt.acronym AS platform_name, com.name AS company_name
FROM (
  SELECT * FROM game_packages WHERE game_id = ?
) pkg
  LEFT OUTER JOIN game_platforms plt ON pkg.platform_id = plt.id
  LEFT OUTER JOIN game_companies com ON pkg.company_id = com.id
SQL;

        return DB::select($sql, [$gameId]);
    }

    /**
     * ベースデータを取得
     *
     * @param Game $game
     * @return array
     */
    private function getBaseData(Game $game)
    {
        $baseData = [];

        // お気に入り数
        $baseData['favorite_num'] = UserFavoriteGame::where('game_id', $game->id)->count('user_id');

        // レビュー数
        $baseData['review_num'] = \Hgs3\Models\Orm\Review::where('game_id', $game->id)->count('id');

        // サイト数
        $baseData['site_num'] = SiteHandleGame::where('game_id', $game->id)->count('site_id');

        return $baseData;
    }

    /**
     * お気に入りゲーム登録ユーザーを取得
     *
     * @param Game $game
     * @return array
     */
    private function getFavoriteUser(Game $game)
    {
        $sql =<<< SQL
SELECT users.id, users.name, users.icon_upload_flag
FROM (
  SELECT user_id FROM user_favorite_games WHERE game_id = ? ORDER BY id LIMIT 5
) fav LEFT OUTER JOIN users ON fav.user_id = users.id
SQL;

        return DB::select($sql, [$game->id]);
    }

    /**
     * サイト情報を取得
     *
     * @param Game $game
     * @return array
     */
    private function getSite(Game $game)
    {
        $siteIds = DB::table('site_search_indices')
            ->where('game_id', $game->id)
            ->orderBy('updated_timestamp', 'DESC')
            ->take(5)
            ->get()->pluck('site_id')->toArray();

        if (empty($siteIds)) {
            return [];
        }

        $siteIdComma = implode(',', $siteIds);

        $sql =<<< SQL
SELECT users.id, users.name, s.id, s.name, s.url, s.presentation, s.rate,
  s.gender, s.main_contents_id, s.out_count, s.in_count, s.good_count
FROM (
  SELECT * FROM sites WHERE id IN ({$siteIdComma})
) s LEFT OUTER JOIN users ON s.user_id = users.id
SQL;

        return DB::select($sql, [$game->id]);
    }

    /**
     * 遊んだプレーヤーを取得
     *
     * @param Game $game
     * @return \Illuminate\Support\Collection
     */
    private function getPlayedUsers(Game $game)
    {
        $sql =<<< SQL
SELECT users.id, users.name
FROM (
  SELECT user_id FROM user_played_games WHERE game_id = ? ORDER BY id LIMIT 5
) fav LEFT OUTER JOIN users ON fav.user_id = users.id
SQL;

        return DB::select($sql, [$game->id]);
    }

    /**
     * ソフト名のハッシュを取得
     *
     * @param array $ids
     * @return array
     */
    public static function getNameHash(array $ids = array())
    {
        $tbl = DB::table('games');

        if (!empty($ids)) {
            $tbl->whereIn('id', $ids);
        }

        return $tbl->get()->pluck('name', 'id')->toArray();
    }

    /**
     * 新規登録
     *
     * @param AddRequest $request
     * @return bool
     */
    public function add(AddRequest $request)
    {
        $game = new Game();

        $game->name = $request->get('name');
        $game->phonetic = $request->get('phonetic');
        $game->phonetic_type = PhoneticType::getTypeByPhonetic($game->phonetic);
        $game->phonetic_order = $request->get('phonetic_order');
        $game->genre = $request->get('genre');
        $game->company_id = $request->get('company_id');
        $game->series_id = $request->get('series_id');
        $game->order_in_series = $request->get('order_in_series');
        $game->game_type = $request->get('game_type');
        $game->original_package_id = null;

        DB::beginTransaction();
        try {
            // 保存
            $game->save();

            // タイムラインに登録
            Timeline::addNewGameSoftText($game->id, $game->name);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            throw $e;
        }
    }
}