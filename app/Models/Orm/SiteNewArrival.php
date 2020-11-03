<?php
/**
 * ORM: site_new_arrivals
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;

class SiteNewArrival extends \Eloquent
{
    protected $primaryKey = ['site_id'];
    public $incrementing = false;
}
