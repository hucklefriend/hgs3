<?php
/**
 * ゲームソフトコントローラー
 */

namespace Hgs3\Http\Controllers\Game;

use Hgs3\Constants\PhoneticType;
use Hgs3\Models\Game\SoftList;
use Hgs3\Models\Orm;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\Review;
use Hgs3\Models\User\FavoriteSoft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoftController extends Controller
{
    /**
     * 一覧ページ
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $favoriteHash = [];
        $isGuest = true;
        $imageType = 1;
        if (Auth::check()) {
            $favoriteHash = FavoriteSoft::getHash(Auth::id());
            $isGuest = false;
            $imageType = Auth::user()->adult == 1 ? 3 : 2;
        }

        $name = $request->query('name', null);
        $platforms = $request->query('platform', []);
        $rate = $request->query('rate', []);

        $data = SoftList::search($isGuest, $name, $platforms, $rate);
        $list = [];
        $hasData = [];
        foreach ($data as $row) {
            $list[$row['phonetic_type']][] = $row;
            $hasData[$row['phonetic_type']] = true;

            if (isset($favoriteHash[$row['id']])) {
                $list[100][] = $row;
                $hasData[100] = true;
            }
        }

        // 初期表示
        $defaultPhoneticType = session('soft_phonetic_type', PhoneticType::getType('あ'));
        if (!isset($hasData[$defaultPhoneticType])) {
            foreach ($hasData as $key => $value) {
                $defaultPhoneticType = $key;
                break;
            }
        }

        $phonetics = [];
        foreach (PhoneticType::getId2CharData() as $phoneticType => $char) {
            if (isset($hasData[$phoneticType])) {
                $phonetics[] = [PhoneticType::getAlphabet($phoneticType), $phoneticType, $char];
            }
        }

        if (isset($hasData[100])) {
            $phonetics[] = ['fav', 100, '<span class="favorite-icon"><i class="fas fa-star"></i></span>'];
        }

        return view('game.soft.index', [
            'phoneticList'        => PhoneticType::getId2CharData(),
            'list'                => $list,//Soft::getList($favoriteHash, $isGuest),
            'favoriteHash'        => $favoriteHash,
            'defaultPhoneticType' => $defaultPhoneticType,
            'imageFile'           => 'image' . $imageType,
            'name'                => $name,
            'platforms'           => $platforms,
            'rate'                => $rate,
            'phonetics'           => $phonetics
        ]);
    }

    /**
     * 詳細ページ
     *
     * @param ?Orm\GameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(?Orm\GameSoft $soft = null)
    {
        session(['soft_phonetic_type' => $soft->phonetic_type]);

        $data = Soft::getDetail($soft);
        $data['favoriteHash'] = [];
        if (Auth::check()) {
            $data['favoriteHash'] = FavoriteSoft::getHash(Auth::id());

            $data['isWriteReview'] = Review::isOpened(Auth::id(), $soft->id);
            $data['isWriteReviewDraft'] = Review::isWriteDraft(Auth::id(), $soft->id);
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
        $packageLink = Orm\GameSoftPackage::where('package_id', $packageId)
            ->orderBy('soft_id')
            ->first();

        if (!empty($packageLink)) {
            return redirect()->route('ゲーム詳細', ['soft' => $packageLink->soft_id]);
        } else {
            return abort(404);
        }
    }
}
