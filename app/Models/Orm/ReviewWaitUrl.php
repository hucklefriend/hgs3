<?php
/**
 * ORM: review_wait_urls
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReviewWaitUrl extends \Eloquent
{
    protected $primaryKey = ['review_id'];
    public $incrementing = false;
    protected $guarded = [];
}
