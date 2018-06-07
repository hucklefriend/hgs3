<?php
/**
 * お気に入りゲームコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Models\Orm;
use Hgs3\Models\User\FavoriteSoft;
use Hgs3\Models\User;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoriteSoftController extends Controller
{
    /**
     * お気に入りゲーム追加
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request)
    {
        $softId = $request->get('soft_id');
        $soft = Orm\GameSoft::find($softId);
        if ($soft != null) {
            FavoriteSoft::add(Auth::user(), $soft);
        }

        return redirect()->back();
    }

    /**
     * お気に入りゲーム削除
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        $softId = $request->get('soft_id');
        $soft = Orm\GameSoft::find($softId);
        if ($soft != null) {
            FavoriteSoft::remove(Auth::user(), $soft);
        }

        return redirect()->back();
    }
}
