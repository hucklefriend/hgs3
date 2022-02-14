<?php
/**
 * ORM: game_softs
 */

namespace Hgs3\Models\Orm;

use Hgs3\Enums\Game\Soft\PhoneticType;
use Hgs3\Enums\RatedR;
use \Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class GameSoft extends AbstractOrm
{
    protected $guarded = ['id'];

    /**
     * @var array デフォルト値
     */
    protected $attributes = [
        'genre' => '',
    ];

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
     * パッケージを取得
     *
     * @return Collection
     */
    public function packages(): Collection
    {
        $packageLinks = GameSoftPackage::where('soft_id', $this->id)->get();
        if ($packageLinks->isEmpty()) {
            return new Collection();
        }

        return GamePackage::whereIn('id', $packageLinks->pluck('package_id'))
            ->orderBy('release_int')->get();
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
    public static function updatePhoneticOrder(): void
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
    public function save(array $options = []): bool
    {
        $this->phonetic_type = PhoneticType::getTypeByPhonetic($this->phonetic);
        $packages = $this->packages();

        if ($packages->isEmpty()) {
            $this->original_package_id = null;
            $this->first_release_int = 0;
            $this->r18_only_flag = 0;
        } else {
            $this->r18_only_flag = 1;

            /* @var GamePackage $package */
            foreach ($packages as $package) {
                // 一番古い発売日をセット
                if ($this->first_release_int == 0) {
                    $this->first_release_int = $package->release_int;
                } else if ($this->first_release_int < $package->release_int) {
                    $this->first_release_int = $package->release_int;
                }

                // R18以外が1つでもあればフラグを下げる
                if ($package->rated_r != RatedR::R18->value) {
                    $this->r18_only_flag = 0;
                }
            }
        }

        $this->genre ??= '';
        $this->introduction ??= '';
        $this->introduction_from ??= '';

        return parent::save($options);
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
        $packageLinks = GameSoftPackage::where('soft_id', $this->id)->get();
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

    /**
     * 現在設定されているパッケージ群から原点パッケージの設定
     *
     * @return void
     */
    public function setOriginalPackage(): void
    {
        $packages = $this->getPackages();
        if ($packages->isEmpty()) {
            $this->original_package_id = null;
        } else {
            $this->original_package_id = $packages[0]->id;
            $this->first_release_int = $packages[0]->release_int;
        }
    }
}
