<?php
/**
 * ORM: game_franchises
 */

namespace Hgs3\Models\Orm;

use Illuminate\Database\Eloquent\Relations\HasMany;

class GameFranchise extends \Eloquent
{
    protected $guarded = ['id'];

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
     * シリーズ
     *
     * @return HasMany
     */
    public function series(): HasMany
    {
        return $this->hasMany(GameSeries::class, 'series_id');
    }
}