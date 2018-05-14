<?php
/**
 * レビュー集計フラグモデル
 */


namespace Hgs3\Models;

use Hgs3\Constants\Review\Status;
use Hgs3\Models\Orm;
use Hgs3\Models\Timeline;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Hgs3\Log;
use Illuminate\Support\Facades\Mail;

class Total
{
    public static function total()
    {
        // 集計対象を取得
    }
}