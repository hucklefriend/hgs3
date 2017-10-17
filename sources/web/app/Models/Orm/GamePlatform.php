<?php
/**
 * ORM: game_platforms
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;

class GamePlatform extends \Eloquent
{
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
