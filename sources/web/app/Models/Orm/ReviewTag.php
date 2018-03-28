<?php
/**
 * ORM: review_tags
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReviewTag extends \Eloquent
{
    protected $primaryKey = ['review_id', 'tag'];
    public $incrementing = false;
    protected $guarded = ['review_id', 'tag'];
}
