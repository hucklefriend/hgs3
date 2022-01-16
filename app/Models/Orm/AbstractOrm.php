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
}