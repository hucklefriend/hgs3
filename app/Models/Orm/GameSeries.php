<?php
/**
 * ORM: game_series
 */

namespace Hgs3\Models\Orm;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameSeries extends \Eloquent
{
    protected $guarded = ['id'];

    /**
     * ソフト
     *
     * @return HasMany
     */
    public function softs(): HasMany
    {
        return $this->hasMany(GameSoft::class, 'series_id');
    }

    /**
     * シリーズに関連しているフランチャイズを取得
     *
     * @return BelongsTo
     */
    public function franchise(): BelongsTo
    {
        return $this->belongsTo(GameFranchise::class, 'franchise_id');
    }

    /**
     * id => nameのハッシュを取得
     *
     * @param array $prepend
     * @return array
     */
    public static function getNameHash(array $prepend = []): array
    {
        $query = self::select(['id', 'name']);

        $data = $query->get()
            ->pluck('name', 'id')
            ->toArray();

        return $prepend + $data;
    }



    /**
     * id => franchise_idのハッシュを取得
     *
     * @param array $prepend
     * @return array
     */
    public static function getFranchiseHash(array $prepend = []): array
    {
        $query = self::select(['id', 'franchise_id']);

        $data = $query->get()
            ->pluck('name', 'franchise_id')
            ->toArray();

        return $prepend + $data;
    }
}
