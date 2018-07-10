<?php
/**
 * ゲームソフト一覧用データ(MongoDB)
 */

namespace Hgs3\Models\Game;

use Hgs3\Models\MongoDB\Collection;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\Regex;


class SoftList
{
    /**
     * データ生成
     */
    public static function generate()
    {
        $col = self::getDB();
        $soft = Orm\GameSoft::all();

        $platforms1 = [4,5,7,8,9,10,11,12,13,17,18,19,24,25,29,33,34,35,37,39];
        $platforms2 = [39,32,14,15,20,21,23,26,28];
        $platforms3 = [3];
        $platforms4 = [30,31,22];

        $col->deleteMany([]);   // 一回全部消す

        foreach ($soft as $s) {
            $doc = [];

            $doc['id'] = intval($s->id);
            $doc['name'] = $s->name;
            $doc['search_name'] = $s->name . ' ' . $s->phonetic; // 検索用、ひらがなも一緒に探すので、スペースで繋げたものを入れちゃう
            $doc['phonetic_type'] = intval($s->phonetic_type);
            $doc['sort'] = intval($s->phonetic_order);
            $doc['series_id'] = intval($s->series_id);
            $doc['order_in_series'] = intval($s->order_in_series);

            $packages = self::getLinkedPackages($s->id);
            $platforms = [0];
            $rate = [];
            $image1 = null;     // ゲストユーザー用画像
            $image2 = null;     // ユーザーでR-18不可用画像
            $image3 = null;     // ユーザーでR-18可用画像
            $noImageUrl = url('img/pkg_no_img_s.png');
            $r18ImageUrl = url('img/pkg_r18_img_s.png');

            foreach ($packages as $pkg) {
                if (in_array($pkg->platform_id, $platforms1)) {
                    $platforms[1] = 1;
                } else if (in_array($pkg->platform_id, $platforms2)) {
                    $platforms[2] = 2;
                } else if (in_array($pkg->platform_id, $platforms3)) {
                    $platforms[3] = 3;
                } else if (in_array($pkg->platform_id, $platforms4)) {
                    $platforms[4] = 4;
                } else {
                    $platforms[5] = 5;
                }

                $isAdult = intval($pkg->is_adult);
                $rate[$isAdult] = $isAdult;

                if ($isAdult == 0) {
                    if ($image1 == null) {
                        $image1 = $pkg->small_image_url;
                    }
                    if ($image2 == null) {
                        $image2 = $pkg->small_image_url;
                    }
                    if ($image3 == null) {
                        $image3 = $pkg->small_image_url;
                    }
                } else {
                    if ($image2 == null) {
                        $image2 = $r18ImageUrl;
                    }
                    if ($image3 == null) {
                        $image3 = $pkg->small_image_url;
                    }
                }
            }

            $doc['image1'] = $image1 ?? $noImageUrl;
            $doc['image2'] = $image2 ?? $noImageUrl;
            $doc['image3'] = $image3 ?? $noImageUrl;

            $doc['platform'] = array_values($platforms);
            $doc['rate'] = array_values($rate);

            $col->insertOne($doc);

            unset($packages);
            unset($platforms);
            unset($releaseYears);
        }
    }

    /**
     * ソフトに紐づくパッケージを取得
     *
     * @param $softId
     * @return array
     */
    private static function getLinkedPackages($softId)
    {
        $sql =<<< SQL
SELECT pkg.id, pkg.platform_id, release_int, is_adult, small_image_url
FROM (SELECT package_id FROM game_package_links WHERE soft_id = :soft_id) links
  INNER JOIN game_packages pkg ON links.package_id = pkg.id
ORDER BY pkg.release_int
SQL;

        return DB::select($sql, ['soft_id' => $softId]);
    }

    /**
     * MongoDBのCollectionを取得
     *
     * @return \MongoDB\Collection
     */
    private static function getDB()
    {
        return Collection::getInstance()->getDatabase()->game_soft_list;
    }

    /**
     * 一覧用の検索
     *
     * @param $isGuest
     * @param $name
     * @param $platforms
     * @param $rate
     * @return array
     */
    public static function search($isGuest, $name, $platforms, $rate)
    {
        $filter = [];

        // 名前で検索(スペースは分けて)
        $n = explode(' 　', preg_quote($name));
        $names = [];
        foreach ($n as $nn) {
            $nn = str_replace('/', '', $nn);
            $nn = str_replace('/', '', $nn);
            if (strlen($nn) > 0) {
                $names[] = $nn;
            }
        }

        if (!empty($names)) {
            $regex = new Regex( implode('|', $names));
            $filter['search_name'] = $regex;
        }

        // プラットフォームで検索
        if (!empty($platforms)) {
            array_walk($platforms, function (&$item, $key) {$item = intval($item);});
            $filter['platform'] = ['$elemMatch' => ['$in' => $platforms]];
        }

        // 年齢制限で検索
        if (!empty($rate)) {
            array_walk($rate, function (&$item, $key) {$item = intval($item);});
            $filter['rate'] = ['$elemMatch' => ['$in' => $rate]];
        } else if ($isGuest) {
            $filter['rate'] = ['$elemMatch' => ['$in' =>[0, 2]]];
        }

        $options = ['sort'  => ['sort' => 1]];

        return self::getDB()->find($filter, $options)->toArray();
    }
}