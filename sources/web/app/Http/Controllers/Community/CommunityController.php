<?php
/**
 * コミュニティコントローラー
 */

namespace Hgs3\Http\Controllers;

use Hgs3\Constants\PhoneticType;
use Hgs3\Constants\UserRole;
use Hgs3\Http\Requests\Game\Soft\UpdateRequest;
use Hgs3\Models\Orm\GameComment;
use Hgs3\Models\User\FavoriteGame;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\Orm\Game;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    /**
     * 一覧ページ
     */
    public function index()
    {
        $soft = new Soft;

        return view('game.soft.list')->with([
            'phoneticList' => PhoneticType::getId2CharData(),
            'list'         => $soft->getList(),
        ]);
    }
}
