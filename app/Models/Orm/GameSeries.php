<?php
/**
 * ORM: game_series
 */

namespace Hgs3\Models\Orm;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameSeries extends AbstractOrm
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
}
