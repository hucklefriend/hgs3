<?php
/**
 * ORM: game_companies
 */

namespace Hgs3\Models\Orm;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameCompany extends \Eloquent
{
    protected $guarded = ['id'];

    /**
     * id => nameのハッシュを取得
     *
     * @param array $companyIds
     * @param array $prepend
     * @return array
     */
    public static function getNameHash(array $companyIds = [], array $prepend = []): array
    {
        $query = self::select(['id', 'acronym']);

        if (!empty($companyIds)) {
            $query->whereIn('id', $companyIds);
        }

        $data = $query->get()
            ->pluck('acronym', 'id')
            ->toArray();

        return $prepend + $data;
    }

    /**
     * ソフト情報を取得
     *
     * @return array
     */
    public function getSoft()
    {
        $sql =<<< SQL
SELECT
  pkg.id, pkg.platform_id, pkg.release_int, pkg.is_adult,
  pkg.medium_image_url, lnk.soft_id
FROM (
  SELECT id, platform_id, release_int, is_adult, medium_image_url
  FROM game_packages
  WHERE company_id = ?
) pkg INNER JOIN game_package_links lnk ON pkg.id = lnk.package_id
ORDER BY
  pkg.release_int
SQL;

        $packages = DB::select($sql, [$this->id]);
        if (empty($packages)) {
            return ['soft' => [], 'packages' => []];
        }

        $soft_ids = \Illuminate\Support\Arr::pluck($packages, 'soft_id');
        $soft = DB::query()->select(['id', 'name'])
            ->from('game_softs')
            ->whereIn('id', $soft_ids)
            ->orderBy('phonetic_order')
            ->get()
            ->keyBy('id');

        // ソフト単位で集約
        $data = [];

        $isAdultUser = false;
        if (Auth::check()) {
            $isAdultUser = Auth::user()->is_adult == 1;
        }

        foreach ($packages as $pkg) {
            if (isset($data[$pkg->soft_id])) {
                // 既にデータあり

                // パッケージがある方を優先
                if (empty($data[$pkg->soft_id]->package_image_url)) {
                    $data[$pkg->soft_id]->package_image_url = $pkg->medium_image_url;
                    $data[$pkg->soft_id]->is_adult = $pkg->is_adult;
                }

                $data[$pkg->soft_id]->platforms[$pkg->platform_id] = $pkg->platform_id;
            } else {
                $data[$pkg->soft_id] = new \stdClass();

                $data[$pkg->soft_id]->medium_image_url = $pkg->medium_image_url;
                $data[$pkg->soft_id]->is_adult = $pkg->is_adult;

                $data[$pkg->soft_id]->platforms = [
                    $pkg->platform_id => $pkg->platform_id,
                ];
            }
        }

        return [
            'soft' => $soft,
            'packages' => $data
        ];
    }
}