<?php
/**
 * ORM: game_companies
 */

namespace Hgs3\Models\Orm;

class GameCompany extends \Eloquent
{
    protected $guarded = [];

    /**
     * id => nameのハッシュを取得
     *
     * @param array $companyIds
     * @return array
     */
    public static function getNameHash(array $companyIds = [])
    {
        $query = self::select(['id', 'acronym']);

        if (!empty($companyIds)) {
            $query->whereIn('id', $companyIds);
        }

        return $query->get()
            ->pluck('acronym', 'id')
            ->toArray();
    }
}