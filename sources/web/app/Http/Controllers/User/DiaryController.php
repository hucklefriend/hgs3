<?php
/**
 * ユーザーの日記コントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    /**
     * ユーザーの日記
     *
     * @param string $showId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($showId)
    {
        return view('diary.index');
    }
}
