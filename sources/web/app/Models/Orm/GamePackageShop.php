<?php
/**
 * ORM: game_package_shops
 */

namespace Hgs3\Models\Orm;

class GamePackageShop extends \Eloquent
{
    protected $primaryKey = ['package_id', 'soft_id'];
    public $incrementing = false;
}
