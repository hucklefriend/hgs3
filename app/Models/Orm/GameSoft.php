<?php
/**
 * ORM: game_softs
 */

namespace Hgs3\Models\Orm;

use Hgs3\Constants\PhoneticType;
use \Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class GameSoft extends \Eloquent
{
    protected $guarded = ['id'];

    /**
     * フランチャイズを取得
     *
     * @return BelongsTo
     */
    public function franchise(): BelongsTo
    {
        return $this->belongsTo(GameFranchise::class, 'franchise_id');
    }

    /**
     * シリーズを取得
     *
     * @return BelongsTo
     */
    public function series(): BelongsTo
    {
        return $this->belongsTo(GameSeries::class, 'series_id');
    }

    /**
     * 原点のパッケージを取得
     * nullがありうる
     *
     * @return HasOne
     */
    public function originalPackage(): HasOne
    {
        return $this->hasOne(GamePackage::class, 'id', 'original_package_id');
    }

    /**
     * ゲームソフト名のハッシュを取得
     *
     * @param array $ids
     * @return array
     */
    public static function getNameHash(array $ids = array()): array
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
     * @param array $favoriteHash
     * @return array
     */
    public static function getPhoneticTypeHash(array $favoriteHash): array
    {
        $data = self::select(['id', 'name', 'phonetic_type'])
            ->orderBy('phonetic_order')
            ->get();

        $result = [];

        foreach ($data as $game) {
            $result[intval($game->phonetic_type)][] = $game;

            if (isset($favoriteHash[$game->id])) {
                $result[100][] = $game;
            }
        }
        unset($data);

        return $result;
    }

    /**
     * データをハッシュで取得
     *
     * @param array $ids
     * @return array
     */
    public static function getHash(array $ids = []): array
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
                $result[$row->id]->is_adult = $packages[$row->original_package_id]->is_adult;
            }
        }

        unset($data);
        return $result;
    }

    /**
     * 表示順を更新
     */
    public static function updateSortOrder(): void
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
     * @param bool $all
     * @return Collection
     */
    public function getPackages(bool $all = false): Collection
    {
        $packageLinks = GamePackageLink::where('soft_id', $this->id)
            ->get();
        if ($packageLinks->isEmpty()) {
            return new Collection();
        }

        $packages = GamePackage::whereIn('id', $packageLinks->pluck('package_id'));
        if (!$all) {
            $packages->where('release_int', '<=', date('Ymd'));
        }

        return $packages->orderBy('release_int')->get();
    }

    /**
     * 発売済みか？
     *
     * @return bool
     */
    public function isReleased(): bool
    {
        return $this->first_release_int <= date('Ymd');
    }
}
