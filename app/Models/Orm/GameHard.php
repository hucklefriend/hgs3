<?php
/**
 * ORM: game_hards
 */

namespace Hgs3\Models\Orm;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameHard extends \Eloquent
{
    protected $guarded = ['id'];

    /**
     * ハードに関連しているメーカーを取得
     *
     * @return BelongsTo
     */
    public function maker(): BelongsTo
    {
        return $this->belongsTo(GameCompany::class);
    }
}
