<?php
/**
 * ORM: game_packages
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;

class GamePackage extends \Eloquent
{
    protected $guarded = ['id'];

    /**
     * データのハッシュを取得
     *
     * @param array $packageIds
     * @return array
     */
    public static function getHash(array $packageIds)
    {
        if (empty($packageIds)) {
            return [];
        }

        $data = self::whereIn('id', $packageIds)
            ->get();

        $hash = [];
        foreach ($data as $row) {
            $hash[$row->id] = $row;
        }

        unset($data);

        return $hash;
    }
}
