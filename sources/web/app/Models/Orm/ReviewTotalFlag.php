<?php
/**
 * ORM: review_total_flags
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReviewTotalFlag extends \Eloquent
{
    protected $primaryKey = 'soft_id';
    public $incrementing = false;
    protected $guarded = ['soft_id'];

}
