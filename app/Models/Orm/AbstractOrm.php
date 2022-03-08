<?php
/**
 * ORMの基底クラス
 */

namespace Hgs3\Models\Orm;

use Carbon\Carbon;
use Hgs3\Log;

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
     * @param array $order
     * @return array
     */
    public static function getHashBy(string $value, string $key = 'id', array $search = [], array $prepend = [], array $append = [], array $order = []): array
    {
        $query = self::select([$key, $value]);

        if (!empty($search)) {
            $query->whereIn($key, $search);
        }

        if (!empty($order)) {
            if (!is_array($order[0])) {
                $order = [$order];
            }

            foreach ($order as [$column, $ascOrDesc]) {
                if (strtolower($ascOrDesc) == 'asc') {
                    $query->orderBy($column);
                } else {
                    $query->orderByDesc($column);
                }
            }
        }

        $data = $query->get()
            ->pluck($value, $key)
            ->toArray();

        return $prepend + $data + $append;
    }
}