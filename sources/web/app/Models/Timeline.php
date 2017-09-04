<?php
/**
 * タイムラインモデル
 */

namespace Hgs3\Models;

use Jenssegers\Mongodb\Model as Eloquent;

class Timeline extends Eloquent
{
    protected $connection = 'mongodb';


    public function add($tltId, $param = [])
    {

    }
}