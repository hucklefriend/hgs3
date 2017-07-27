<?php
/**
 * ゲームソフトモデル
 */

namespace Hgs3\Models\Game;

use Hgs3\Models\Orm\GameCompany;
use Hgs3\Models\Orm\GamePackage;
use Hgs3\Models\Orm\ReviewTotal;
use Hgs3\Models\Orm\SiteHandleGame;
use Hgs3\Models\Orm\UserFavoriteGame;
use Illuminate\Support\Facades\DB;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\GameSeries;

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
        if ($game->company_id != null) {
            $data['company'] = GameCompany::find($game->company_id);
        } else {
            $data['company'] = null;
        }

        // パッケージ情報
        $data['packages'] = $this->getDetailPackages($game->id);

        // レビュー
        $data['review'] = ReviewTotal::find($game->id);

        // ベースデータ
        $data['base'] = $this->getBaseData($game);

        // お気に入り登録ユーザー
        $data['favorite'] = $this->getFavoriteUser($game);

        // サイト
        $data['site'] = $this->getSite($game);

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
SELECT pkg.*, plt.id plt_id, plt.name AS platform_name
FROM (
  SELECT * FROM game_packages WHERE game_id = ?
) pkg
  LEFT OUTER JOIN game_platforms plt ON pkg.platform_id = plt.id
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
SELECT users.id, users.name
FROM (
  SELECT user_id FROM user_favorite_games WHERE game_id = ? ORDER BY id LIMIT 10
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
        $siteIds = DB::table('site_handle_games')
            ->where('game_id', $game->id)
            ->orderBy('updated_at')
            ->take(5)
            ->get()->pluck('site_id');

        if (empty($siteIds)) {
            return [];
        }

        $siteIdComma = implode(',', $siteIds->toArray());

        $sql =<<< SQL
SELECT users.id, users.name, s.id, s.name, s.url, s.presentation, s.rate,
  s.gender, s.main_contents_id, s.out_count, s.in_count, s.good_count
FROM (
  SELECT * FROM sites WHERE id IN ({$siteIdComma}) ORDER BY updated_timestamp
) s LEFT OUTER JOIN users ON s.user_id = users.id
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
}