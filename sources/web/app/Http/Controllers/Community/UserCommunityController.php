<?php
/**
 * ユーザーコミュニティコントローラー
 */

namespace Hgs3\Http\Controllers\Community;

use Hgs3\Constants\PhoneticType;
use Hgs3\Constants\UserRole;
use Hgs3\Http\Requests\Game\Soft\UpdateRequest;
use Hgs3\Models\Orm\GameComment;
use Hgs3\Models\Orm\UserCommunity;
use Hgs3\Models\User\FavoriteGame;
use Hgs3\User;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\Orm\Game;
use Illuminate\Support\Facades\Auth;

class UserCommunityController extends Controller
{
    /**
     * ユーザーコミュニティトップページ
     *
     * @param UserCommunity $uc
     * @return $this
     */
    public function detail(UserCommunity $uc)
    {
        $model = new \Hgs3\Models\Community\UserCommunity();

        return view('community.user.detail')->with([
            'uc'      => $uc,
            'members' => $model->getOlderMembers($uc->id)
        ]);
    }
}
