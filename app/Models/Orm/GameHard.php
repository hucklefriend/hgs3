<?php
/**
 * ORM: game_hards
 */

namespace Hgs3\Models\Orm;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    /**
     * パッケージを取得
     *
     * @return BelongsToMany
     */
    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(GamePackage::class);
    }

    /**
     * 標準の<select>用リスト取得
     * 特殊なデータが欲しい場合は自前で実装
     *
     * @return array
     */
    public static function getSelectList(): array
    {
        return self::getHashBy('name', prepend: ['' => ' '], order: ['sort_order', 'DESC']);
    }
}
