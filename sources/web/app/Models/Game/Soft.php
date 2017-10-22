<?php
/**
 * ゲームソフトモデル
 */

namespace Hgs3\Models\Game;

use Hgs3\Constants\PhoneticType;
use Hgs3\Http\Requests\Game\Soft\AddRequest;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
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
        $tmp = DB::table('game_softs')
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
     * @param Orm\GameSoft $gameSoft
     * @return array
     */
    public function getDetail(Orm\GameSoft $gameSoft)
    {
        $data = ['gameSoft' => $gameSoft];

        // 同じシリーズのソフト取得
        if ($gameSoft->series_id != null) {
            $data['gameSeries'] = Orm\GameSeries::find($gameSoft->series_id);
            if ($data['gameSeries']) {
                $data['seriesSofts'] = $this->getSameSeries($gameSoft->id, $gameSoft->series_id);
            }
        } else {
            $data['series'] = null;
        }

        // パッケージ情報
        $data['packages'] = $this->getPackages($gameSoft->id);
        $data['packageNum'] = count($data['packages']);

        // レビュー
        $data['reviewTotal'] = Orm\ReviewTotal::find($gameSoft->id);

        // お気に入り登録ユーザー
        $data['favorite'] = $this->getFavoriteUser($gameSoft);

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
     * @param $gameSoftId
     * @param $gameSeriesId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    private function getSameSeries($gameSoftId, $gameSeriesId)
    {
        return Orm\GameSoft::select(['id', 'name'])
            ->where('series_id', $gameSeriesId)
            ->where('id', '<>', $gameSoftId)
            ->orderBy('order_in_series')
            ->get();
    }

    /**
     * パッケージの一覧を取得
     *
     * @param int $gameSoftId
     * @return array
     */
    private function getPackages($gameSoftId)
    {
        $sql =<<< SQL
SELECT pkg.*, plt.acronym AS platform_name, com.name AS company_name
FROM (
  SELECT id, `name`, platform_id, release_date, company_id FROM game_packages WHERE soft_id = ?
) pkg
  LEFT OUTER JOIN game_platforms plt ON pkg.platform_id = plt.id
  LEFT OUTER JOIN game_companies com ON pkg.company_id = com.id
SQL;

        return DB::select($sql, [$gameSoftId]);
    }

    /**
     * お気に入りゲーム登録ユーザーを取得
     *
     * @param Orm\GameSoft $gameSoft
     * @return array
     */
    private function getFavoriteUser(Orm\GameSoft $gameSoft)
    {
        $sql =<<< SQL
SELECT users.id, users.name, users.icon_upload_flag
FROM (
  SELECT user_id FROM user_favorite_softs WHERE soft_id = ? ORDER BY id LIMIT 5
) fav LEFT OUTER JOIN users ON fav.user_id = users.id
SQL;

        return DB::select($sql, [$gameSoft->id]);
    }

    /**
     * サイト情報を取得
     *
     * @param GameSoft $game
     * @return array
     */
    private function getSite(GameSoft $game)
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
  s.gender, s.main_contents_id, s.out_count, s.in_count, s.good_num
FROM (
  SELECT * FROM sites WHERE id IN ({$siteIdComma})
) s LEFT OUTER JOIN users ON s.user_id = users.id
SQL;

        return DB::select($sql, [$game->id]);
    }

    /**
     * 遊んだプレーヤーを取得
     *
     * @param GameSoft $game
     * @return \Illuminate\Support\Collection
     */
    private function getPlayedUsers(GameSoft $game)
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
        $game = new GameSoft();

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