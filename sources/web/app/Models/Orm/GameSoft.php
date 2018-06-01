<?php
/**
 * ORM: game_softs
 */

namespace Hgs3\Models\Orm;

use Hgs3\Constants\PhoneticType;
use Hgs3\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class GameSoft extends \Eloquent
{
    protected $guarded = [];

    /**
     * ゲームソフト名のハッシュを取得
     *
     * @param array $ids
     * @return mixed
     */
    public static function getNameHash(array $ids = array())
    {
        $tbl = DB::table('game_softs')
            ->select(['id', 'name']);

        if (!empty($ids)) {
            $tbl->whereIn('id', $ids);
        }

        return $tbl->get()->pluck('name', 'id')->toArray();
    }

    /**
     * よみがた単位でハッシュを取得
     *
     * @param array $ids
     * @return mixed
     */
    public static function getPhoneticTypeHash()
    {
        $data = self::select(['id', 'name', 'phonetic_type'])
            ->orderBy('phonetic_order')
            ->get();

        $result = [];

        foreach ($data as $game) {
            $result[intval($game->phonetic_type)][] = $game;
        }
        unset($data);

        return $result;
    }

    /**
     * データをハッシュで取得
     *
     * @param array $ids
     * @return mixed
     */
    public static function getHash(array $ids = [])
    {
        if (empty($ids)) {
            $data = self::get();
        } else {
            $data = self::whereIn('id', $ids)
                ->get();
        }

        // オリジナルパッケージの情報を取得
        $packages = GamePackage::getHash($data->pluck('original_package_id')->toArray());

        $result = [];
        foreach ($data as $row) {
            $result[$row->id] = $row;

            if (isset($packages[$row->original_package_id])) {
                $result[$row->id]->small_image_url = $packages[$row->original_package_id]->small_image_url;
                $result[$row->id]->medium_image_url = $packages[$row->original_package_id]->medium_image_url;
                $result[$row->id]->large_image_url = $packages[$row->original_package_id]->large_image_url;
            }
        }

        unset($data);
        return $result;
    }

    /**
     * 表示順を更新
     */
    public static function updateSortOrder()
    {
        // SQL文1発でできそうだけど、複雑になるのでループ回して1つずつ更新
        // その後、複雑ではなくなったけど、このままのやりかたで

        $sql =<<< SQL
SELECT id
FROM game_softs
ORDER BY phonetic2
SQL;

        $data = DB::select($sql);
        $n = count($data);

        $update =<<< SQL
UPDATE game_softs SET phonetic_order = ?
WHERE id = ?
SQL;

        for ($i = 1; $i <= $n; $i++) {
            DB::update($update, [$i, $data[$i - 1]->id]);
        }
    }

    /**
     * 保存
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $this->phonetic_type = PhoneticType::getTypeByPhonetic($this->phonetic);

        return parent::save();
    }

    /**
     * オリジナルパッケージを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function originalPackage()
    {
        return $this->hasOne('Hgs3\Models\Orm\GamePackage', 'id', 'original_package_id')
            ->first();
    }

    /**
     * パッケージ画像があるパッケージを取得
     */
    public function getImagePackage()
    {
        $packages = $this->getPackages();
        if ($packages->count() == 0) {
            return null;
        }

        foreach ($packages as $pkg) {
            if (!empty(small_image_url($pkg))) {
                return $pkg;
            }
        }

        return null;
    }

    /**
     * パッケージを取得
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPackages()
    {
        $packageLinks = GamePackageLink::where('soft_id', $this->id)
            ->get();
        if ($packageLinks->isEmpty()) {
            return new Collection();
        }

        return GamePackage::whereIn('id', $packageLinks->pluck('package_id'))
            ->get();
    }

    public static function getNum()
    {
        DB::table('game_softs')
            ->select([DB::raw('COUNT(id) AS num')])
            ->get('num');
    }
}
