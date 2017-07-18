<?php
/**
 * ゲームソフトモデル
 */

namespace Hgs3\Models\Game;

use Hgs3\Models\Orm\GameCompany;
use Hgs3\Models\Orm\GamePackage;
use Hgs3\Models\Orm\ReviewTotal;
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

        // コメント
        $data['comments'] = $this->getComment($game->id);

        // レビュー
        $data['review'] = ReviewTotal::find($game->id);

        return $data;
    }

    /**
     * コメント取得
     *
     * @param $gameId
     * @return array
     */
    private function getComment($gameId)
    {
        $sql =<<< SQL
SELECT
  com.*
  , users.name AS user_name
FROM (
    SELECT id, user_id, type, comment, created_at
    FROM game_comments
    WHERE game_id = ?
    ORDER BY id DESC
    LIMIT 5
  ) com LEFT OUTER JOIN users ON com.user_id = users.id
SQL;

        return DB::select($sql, [$gameId]);
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