<?php
/**
 * ORM: game_platforms
 */

namespace Hgs3\Models\Orm;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GamePlatform extends \Eloquent
{
    protected $guarded = [''];

    /**
     * ソフト情報を取得
     *
     * @return array
     */
    public function getSoft()
    {
        $sql =<<< SQL
SELECT
  pkg.id, pkg.release_int, pkg.is_adult,
  pkg.medium_image_url, lnk.soft_id
FROM (
  SELECT id, platform_id, release_int, is_adult, medium_image_url
  FROM game_packages
  WHERE platform_id = ?
) pkg INNER JOIN game_package_links lnk ON pkg.id = lnk.package_id
ORDER BY
  pkg.release_int
SQL;

        $packages = DB::select($sql, [$this->id]);
        if (empty($packages)) {
            return [];
        }

        $soft_ids = array_pluck($packages, 'soft_id');
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
                if (empty($data[$pkg->soft_id]->package_image_url) && $pkg->is_adult && !$isAdultUser) {
                    $data[$pkg->soft_id]->package_image_url = $pkg->medium_image_url;
                    $data[$pkg->soft_id]->is_adult = $pkg->is_adult;
                }
            } else {
                $data[$pkg->soft_id] = new \stdClass();

                if ($pkg->is_adult && !$isAdultUser) {
                    $data[$pkg->soft_id]->package_image_url = '';
                    $data[$pkg->soft_id]->is_adult = 0;
                } else {
                    $data[$pkg->soft_id]->package_image_url = $pkg->medium_image_url;
                    $data[$pkg->soft_id]->is_adult = $pkg->is_adult;
                }
            }
        }

        return [
            'soft' => $soft,
            'packages' => $data
        ];
    }
}
