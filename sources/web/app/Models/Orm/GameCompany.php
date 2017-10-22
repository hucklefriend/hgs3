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
    public static function getNameHash(array $companyIds = [])
    {
        $query = self::select(['id', 'name']);

        if (!empty($companyIds)) {
            $query->whereIn('id', $companyIds);
        }

        return $query->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}