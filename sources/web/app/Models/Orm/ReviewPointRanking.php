<?php
/**
 * ORM: review_point_rankings
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReviewPointRanking extends \Eloquent
{
    protected $primaryKey = 'soft_id';
    public $incrementing = false;
    protected $guarded = ['soft_id'];
}
