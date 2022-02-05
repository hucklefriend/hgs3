<?php
/**
 * ORM: game_hards
 */

namespace Hgs3\Models\Orm;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameHard extends AbstractOrm
{
    protected $guarded = ['id'];

    /**
     * ハードに関連しているメーカーを取得
     *
     * @return BelongsTo
     */
    public function maker(): BelongsTo
    {
        return $this->belongsTo(GameMaker::class, 'maker_id');
    }
}
