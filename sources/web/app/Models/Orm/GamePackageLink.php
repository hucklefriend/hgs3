<?php
/**
 * ORM: game_packages
 */

namespace Hgs3\Models\Orm;
use Illuminate\Database\Eloquent\Model;

class GamePackageLink extends \Eloquent
{
    protected $primaryKey = ['soft_id', 'package_id'];
    public $incrementing = false;
}
