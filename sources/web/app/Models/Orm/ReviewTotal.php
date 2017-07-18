<?php
/**
 * ORM: review_totals
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;

class ReviewTotal extends Model
{
    protected $primaryKey = 'game_id';
    public $incrementing = false;
    protected $guarded = ['game_id'];
}
