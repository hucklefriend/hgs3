<?php
/**
 * ORM: game_platforms
 */

namespace Hgs3\Models\Orm;

class GamePlatform extends \Eloquent
{
    protected $guarded = ['id'];

    /**
     * パッケージを取得
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPackages()
    {
        return GamePackage::where('platform_id', $this->id)
            ->orderBy('release_int')
            ->paginate(30);
    }
}
