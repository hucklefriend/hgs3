<?php
/**
 * マイページコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    /**
     * マイページ
     *
     * @return $this
     */
    public function index()
    {
        return redirect()->route('プロフィール', ['showId' => Auth::user()->show_id]);
    }
}
