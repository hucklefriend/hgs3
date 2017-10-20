<?php
/**
 * ORM: game_companies
 */

namespace Hgs3\Models\Orm;

use Illuminate\Database\Eloquent\Model;

class GameCompany extends \Eloquent
{
    protected $guarded = ['id'];

    /**
     * id => nameのハッシュを取得
     *
     * @param array $companyIds
     * @return array
     */
    public static function getNameHash(array $companyIds)
    {
        return self::select(['id', 'name'])
            ->whereIn('id', $companyIds)
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}