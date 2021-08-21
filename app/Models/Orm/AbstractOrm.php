<?php
/**
 * ORMの基底クラス
 */

namespace Hgs3\Models\Orm;

class AbstractOrm extends \Eloquent
{
    /**
     * created_atをDateTimeで取得
     *
     * @return ?\DateTime
     * @throws \Exception
     */
    public function getCreatedAt() : ?\DateTime
    {
        return $this->created_at === null ? null : new \DateTime($this->created_at);
    }

    /**
     * updated_atをDateTimeで取得
     *
     * @return ?\DateTime
     * @throws \Exception
     */
    public function getUpdatedAt() : ?\DateTime
    {
        return $this->updated_at === null ? null : new \DateTime($this->updated_at);
    }
}