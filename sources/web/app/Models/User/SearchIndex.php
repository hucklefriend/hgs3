<?php
/**
 * プロフィールモデル
 */


namespace Hgs3\Models\User;
use Hgs3\Models\MongoDB\Collection;
use Hgs3\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class SearchIndex
{
    /**
     * 保存
     *
     * @param User $user
     * @param int|null $time
     */
    public static function save(User $user, $time = null)
    {
        $db = self::getDB();

        $attr = array_values($user->getUserAttributes());
        $sns = array_values($user->getOpenedSns());

        // intにする
        array_walk($attr, function (&$item, $key) {$item = intval($item);});
        array_walk($sns, function (&$item, $key) {$item = intval($item);});

        $db->replaceOne(
            ['id' => $user->id],
            [
                'id'        => $user->id,
                'open_profile_flag' => $user->open_profile_flag,
                'attribute' => $attr,
                'sns'       => $sns,
                'time'      => $time ?? time()
            ],
            ['upsert' => true]
        );
    }

    /**
     * ページネーションデータを取得
     *
     * @param array $attribute
     * @param array $sns
     * @param $num
     * @return LengthAwarePaginator
     */
    public static function paginate(array $attribute, array $sns, $num)
    {
        $req = request();
        $page = $req->query('page', 1);

        $target = [2];
        if (Auth::check()) {
            $target[] = 1;
        }

        $filter = ['open_profile_flag' => ['$in' => $target]];

        if (!empty($attribute)) {
            array_walk($attribute, function (&$item, $key) {$item = intval($item);});
            $filter['attribute'] = ['$elemMatch' => ['$in' => $attribute]];
        }

        if (!empty($sns)) {
            array_walk($sns, function (&$item, $key) {$item = intval($item);});
            $filter['sns'] = ['$elemMatch' => ['$in' => $sns]];
        }

        $options = [
            'sort'  => ['time' => -1],
            'limit' => $num,
            'skip'  => ($page - 1) * $num
        ];

        $dataNum = self::getDB()->count($filter);
        $items = self::getDB()->find($filter, $options)->toArray();

        return new LengthAwarePaginator($items, $dataNum, $num, $page, ['path' => request()->url()]);
    }

    private static function getDB()
    {
        return Collection::getInstance()->getDatabase()->user_search_index;
    }
}