<?php
/**
 * ORM: review_wait_urls
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReviewDisableTerm extends \Eloquent
{
    protected $primaryKey = ['user_id', 'soft_id'];
    public $incrementing = false;
    protected $guarded = [];
}
