<?php
/**
 * ゲームソフトコントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Constants\PhoneticType;
use Hgs3\Http\Requests\Game\GameSoftRequest;
use Hgs3\Models\Orm;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\User\FavoriteSoft;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SoftController extends Controller
{
    /**
     * 一覧ページ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $favoriteHash = [];
        if (Auth::check()) {
            $favoriteHash = FavoriteSoft::getHash(Auth::id());
        }

        return view('game.soft.index', [
            'phoneticList'        => PhoneticType::getId2CharData(),
            'list'                => Soft::getList(),
            'favoriteHash'        => $favoriteHash,
            'defaultPhoneticType' => session('soft_phonetic_type', PhoneticType::getType('あ'))
        ]);
    }

    /**
     * 詳細ページ
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Orm\GameSoft $soft)
    {
        session(['soft_phonetic_type' => $soft->phonetic_type]);

        $data = Soft::getDetail($soft);
        $data['favoriteHash'] = [];
        if (Auth::check()) {
            $data['favoriteHash'] = FavoriteSoft::getHash(Auth::id());
        }

        $data['pltHash'] = Orm\GamePlatform::all('id', 'acronym')
            ->pluck('acronym', 'id');

        return view('game.soft.detail', $data);
    }

    /**
     * パッケージIDからゲーム詳細に飛ぶ
     *
     * @param $packageId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function detailByPackage($packageId)
    {
        $packageLink = Orm\GamePackageLink::where('package_id', $packageId)
            ->orderBy('soft_id')
            ->first();

        if (!empty($packageLink)) {
            return redirect()->route('ゲーム詳細', ['soft' => $packageLink->soft_id]);
        } else {
            return abort(404);
        }
    }
}
