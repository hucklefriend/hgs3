<?php
/**
 * トップページコントローラー
 */

namespace Hgs3\Http\Controllers;


use Hgs3\Models\Orm;
use Hgs3\Models\Orm\NewInformation;
use Hgs3\Models\VersionUp\MasterImport\Soft;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class TopController extends Controller
{
    /**
     * トップページ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $newInfo = NewInformation::getPager();
        $newInfoData = NewInformation::getPagerData($newInfo);

        $notices = Orm\SystemNotice::select(array('id', 'title', DB::raw('DATE_FORMAT(open_at, "%Y/%m/%d %H:%i") AS open_at_str')))
            ->where('open_at', '<=', DB::raw('NOW()'))
            ->where('close_at', '>=', DB::raw('NOW()'))
            ->orderBy('open_at', 'DESC')
            ->take(5)
            ->get();

        return view('top', [
            'newInfo'     => $newInfo,
            'newInfoData' => $newInfoData,
            'notices'     => $notices
        ]);
    }

    /**
     * サイトマップ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sitemap()
    {
        return view('sitemap');
    }

    public function test()
    {
        if (env('APP_ENV') != 'local') {
            return abort(403);
        }

        $soft = new Soft();
        $soft->import();
    }
}
