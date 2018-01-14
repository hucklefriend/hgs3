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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        View::share('navActive', 'home');
    }

    /**
     * トップページ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (Auth::check()) {
            // ログイン中ならマイページに飛ばす
            return redirect('mypage');
        }

        $newInfo = NewInformation::getPager();
        $newInfoData = NewInformation::getPagerData($newInfo);

        $notices = Orm\SystemNotice::where('open_at', '<=', DB::raw('NOW()'))
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
     * 管理トップ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function admin()
    {
        return view('top.admin');
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
