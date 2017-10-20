<?php
/**
 * トップページコントローラー
 */

namespace Hgs3\Http\Controllers;

use Hgs3\Constants\UserRole;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Orm\NewInformation;
use Hgs3\Models\VersionUp\MasterImport\Company;
use Hgs3\Models\VersionUp\MasterImport\Platform;
use Hgs3\Models\VersionUp\MasterImport\Series;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
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

        return view('top', [
            'newInfo'     => $newInfo,
            'newInfoData' => $newInfoData,
        ]);
    }

    /**
     * 管理トップ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function admin()
    {
        return view('admin.top');
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

        $test = new Series();
        $test->import();

        return '';
    }
}
