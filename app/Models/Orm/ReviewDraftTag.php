<?php
/**
 * ORM: review_draft_tags
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReviewDraftTag extends \Eloquent
{
    protected $primaryKey = ['user_id', 'soft_id', 'tag'];
    public $incrementing = false;
    protected $guarded = ['user_id', 'soft_id', 'tag'];
}
