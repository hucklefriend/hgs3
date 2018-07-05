<?php
/**
 * Friendコントローラ
 */

namespace Hgs3\Http\Controllers\Friend;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Friend;
use Hgs3\Models\User;
use Hgs3\Models\User\SearchIndex;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * フレンドトップページ
     */
    public function index(Request $request)
    {
        $attribute = $request->get('attr', []);
        $sns = $request->get('sns', []);
        if (!is_array($attribute)) {
            $attribute = [];
        }
        if (!is_array($sns)) {
            $sns = [];
        }

        $pager = SearchIndex::paginate($attribute, $sns, 20);

        return view('friend.index', [
            'pager' => $pager,
            'attr'  => $attribute,
            'sns'   => $sns,
            'users' => User::getHash(page_pluck($pager, 'id'))
        ]);
    }
}
