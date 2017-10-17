<?php

namespace Hgs3\Http\Controllers;

use Hgs3\Constants\UserRole;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        View::share('isDataEditor', UserRole::isDataEditor());
        View::share('isAdmin', UserRole::isAdmin());
    }
}
