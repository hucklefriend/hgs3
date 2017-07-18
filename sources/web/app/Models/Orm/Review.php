<?php
/**
 * ORM: reviews
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * 保存
     *
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        // ポイントは怖さ値×4+それ以外の値の合算×2
        $this->point =
            $this->fear * 4 + ($this->story + $this->volume + $this->difficulty +
            $this->graphic + $this->sound + $this->crowded + $this->controllability + $this->recommend) * 2;

        return parent::save($options);
    }
}
