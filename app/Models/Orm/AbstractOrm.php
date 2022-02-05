<?php
/**
 * ORMの基底クラス
 */

namespace Hgs3\Models\Orm;

use Carbon\Carbon;

class AbstractOrm extends \Eloquent
{
    /**
     * created_atをCarbonで取得
     *
     * @return ?Carbon
     * @throws \Exception
     */
    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at === null ? null : new Carbon($this->created_at);
    }

    /**
     * updated_atをCarbonで取得
     *
     * @return ?Carbon
     * @throws \Exception
     */
    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at === null ? null : new Carbon($this->updated_at);
    }

    /**
     * 指定カラムのハッシュを取得
     *
     * @param string $value
     * @param string $key
     * @param array $search
     * @param array $prepend
     * @param array $append
     * @return array
     */
    public static function getHashBy(string $value, string $key = 'id', array $search = [], array $prepend = [], array $append = []): array
    {
        $query = self::select([$key, $value]);

        if (!empty($search)) {
            $query->whereIn($key, $search);
        }

        $data = $query->get()
            ->pluck($value, $key)
            ->toArray();

        return $prepend + $data + $append;
    }
}