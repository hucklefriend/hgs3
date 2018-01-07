<?php
/**
 * ORM: used_show_ids
 */

namespace Hgs3\Models\Orm;
use Hgs3\Models\Timeline;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UsedShowIds extends \Eloquent
{
    protected $guarded = ['show_id'];
}
