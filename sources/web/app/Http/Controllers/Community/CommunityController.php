<?php
/**
 * コミュニティコントローラー
 */

namespace Hgs3\Http\Controllers\Community;

use Hgs3\Models\Orm;
use Hgs3\Http\Controllers\Controller;

class CommunityController extends Controller
{
    /**
     * 一覧ページ
     */
    public function index()
    {
        $userCommunities = Orm\UserCommunity::orderBy('id')->get();

        return view('community.index')->with([
            'userCommunities' => $userCommunities
        ]);
    }
}
