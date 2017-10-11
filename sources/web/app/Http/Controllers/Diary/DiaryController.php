<?php
/**
 * 日記コントローラー
 */

namespace Hgs3\Http\Controllers\Diary;

use Hgs3\Http\Requests\User\Site\AddRequest;
use Hgs3\Http\Requests\User\Site\UpdateRequest;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\Site;
use Hgs3\User;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'diary');
    }

    /**
     * 日記トップページ
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $user)
    {
        return view('diary.index');
    }
}
