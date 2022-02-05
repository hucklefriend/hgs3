<?php
/**
 * ORM: game_franchises
 */

namespace Hgs3\Models\Orm;

use Illuminate\Database\Eloquent\Relations\HasMany;

class GameFranchise extends AbstractOrm
{
    protected $guarded = ['id'];

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