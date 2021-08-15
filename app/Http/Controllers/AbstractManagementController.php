<?php
/**
 * 管理用のコントローラー基底クラス
 */

namespace Hgs3\Http\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class AbstractManagementController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        Paginator::useBootstrap();

        $routeName = Route::currentRouteName();
        $routeNames = explode('-', $routeName);

        View::share('menuCategory1', $routeNames[1] ?? null);
        View::share('menuCategory2', $routeNames[2] ?? null);
        View::share('menuCategory3', $routeNames[3] ?? null);
        View::share('menuCategory4', $routeNames[4] ?? null);
        View::share('menuCategory5', $routeNames[5] ?? null);
    }
}