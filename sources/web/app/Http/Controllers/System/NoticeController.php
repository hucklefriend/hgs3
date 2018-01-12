<?php
/**
 * お知らせコントローラー
 */

namespace Hgs3\Http\Controllers\System;

use Hgs3\Http\Requests\Game\GameCompanyRequest;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\System\NoticeRequest;
use Hgs3\Models\Game\Collection;
use Hgs3\Models\Game\Package;
use Hgs3\Models\Orm;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    /**
     * 一覧
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $notices = Orm\SystemNotice::orderBy('open_at', 'DESC')
            ->paginate(30);

        return view('system.notice.index', [
            'notices' => $notices
        ]);
    }

    /**
     * 詳細
     *
     * @param Orm\GameCompany $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Orm\GameCompany $company)
    {
        $packages = Orm\GamePackage::where('company_id', $company->id)
            ->orderBy('release_int')
            ->paginate(15);

        $shops = [];
        $items = $packages->items();
        if (!empty($items)) {
            \ChromePhp::info($items);
            $shops = Package::getShopData(array_pluck($items, 'id'));
        }

        return view('game.company.detail', [
            'company'  => $company,
            'packages' => $packages,
            'shops'    => $shops
        ]);
    }

    /**
     * 追加画面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('system.notice.add');
    }

    /**
     * データ追加
     *
     * @param NoticeRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function insert(NoticeRequest $request)
    {
        $notice = new Orm\SystemNotice();
        $notice->title = $request->input('title');
        $notice->message = $request->input('message');
        $notice->type = $request->input('type');
        $notice->open_at = $request->input('open_at');
        $notice->close_at = $request->input('close_at');

        $notice->save();

        return redirect('system/notice');
    }

    /**
     * 編集画面
     *
     * @param Orm\GameCompany $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Orm\GameCompany $company)
    {
        return view('game.company.edit', [
            'company' => $company
        ]);
    }

    /**
     * データ更新
     *
     * @param GameCompanyRequest $request
     * @param Orm\GameCompany $company
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(GameCompanyRequest $request, Orm\GameCompany $company)
    {
        $company->name = $request->input('name');
        $company->phonetic = $request->input('phonetic');
        $company->url = $request->input('url');
        $company->wikipedia = $request->input('wikipedia');

        $company->save();

        return redirect('game/company/detail/' . $company->id);
    }
}
