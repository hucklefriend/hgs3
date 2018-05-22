<?php
/**
 * ORM: review_impression_histories
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;

class ReviewImpressionHistory extends \Eloquent
{
    protected $guarded = [];
    protected $primaryKey = ['user_id', 'review_id'];
    public $incrementing = false;
}
