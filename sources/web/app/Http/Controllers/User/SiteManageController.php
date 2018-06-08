<?php
/**
 * サイト管理コントローラー
 */


namespace Hgs3\Http\Controllers\User;

use Hgs3\Constants\Site\ApprovalStatus;
use Hgs3\Constants\Site\Gender;
use Hgs3\Constants\Site\MainContents;
use Hgs3\Constants\Site\Rate;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\Site\UpdateHistoryRequest;
use Hgs3\Http\Requests\User\SiteManage;
use Hgs3\Log;
use Hgs3\Models\Site;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Hgs3\Models\Timeline;
use Illuminate\Support\Facades\Auth;

class SiteManageController extends Controller
{
    /**
     * トップ
     *
     * @param string $showId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($showId = null)
    {
        if ($showId == null) {
            $user = Auth::user();
        } else {
            $user = User::findByShowId($showId);
            if ($user == null) {
                return view('user.profile.notExist');
            }
        }

        $isMyself = Auth::id() == $user->id;

        return view('user.profile.site', [
            'user'        => $user,
            'isMyself'    => $isMyself,
            'sites'       => Site::getUserSites($user->id, $isMyself),
            'hasHgs2Site' => Site\TakeOver::hasHgs2Site($user)
        ]);
    }

    /**
     * サイト追加画面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        // サイト登録可能数チェック
        if (Site::isMax(Auth::id())) {
            return view('user.siteManage.max');
        }

        disable_footer_sponsored();

        return view('user.siteManage.add', [
            'softs'      => Orm\GameSoft::getPhoneticTypeHash(),
            'site'       => new Orm\Site([
                'main_contents_id' => MainContents::WALKTHROUGH,
                'rate'               => Rate::ALL,
                'gender'             => Gender::NONE,
            ])
        ]);
    }

    /**
     * サイト追加
     *
     * @param SiteManage\AddRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function insert(SiteManage\AddRequest $request)
    {
        // サイト登録可能数チェック
        if (Site::isMax(Auth::id())) {
            return view('user.siteManage.max');
        }

        $site = new Orm\Site;
        $site->in_count = 0;
        $site->out_count = 0;
        $site->registered_timestamp = time();

        $this->setRequestData($site, $request);
        $site->open_type = 0;
        $site->good_num = 0;
        $site->max_good_num = 0;
        $site->bad_num = 0;
        $site->updated_timestamp = 0;       // 更新日時は0

        // 登録処理
        Site::insert(Auth::user(), $site);

        return redirect()->route('サイトバナー設定', ['site' => $site->id, 'isFirst' => 1]);
    }


    /**
     * バナー設定画面
     *
     * @param Orm\Site $site
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function banner(Orm\Site $site, $isFirst = 0)
    {
        // 本人しか更新できない
        if ($site->user_id != Auth::id()) {
            return $this->forbidden(['site_id' => $site->id]);
        }

        $isFirst = $isFirst != 0;

        disable_footer_sponsored();

        $listBannerUrl = '';
        $listBannerUploadFlag = old('list_banner_upload_flag', false);
        if (!$isFirst && $listBannerUploadFlag === false) {
            $listBannerUploadFlag = 3;
        }

        if ($listBannerUploadFlag == 1) {
            $listBannerUrl = old('list_banner_url', $site->list_banner_url);
        }

        $detailBannerUrl = '';
        $detailBannerUploadFlag = old('detail_banner_upload_flag', false);
        if (!$isFirst && $detailBannerUploadFlag === false) {
            $detailBannerUploadFlag = 3;
        }

        if ($detailBannerUploadFlag == 1) {
            $detailBannerUrl = old('detail_banner_url', $site->detail_banner_url);
        }

        return view('user.siteManage.banner', [
            'site' => $site,
            'user' => Auth::user(),
            'isFirst' => $isFirst,
            'listBannerUploadFlag'   => $listBannerUploadFlag,
            'listBannerUrl'          => $listBannerUrl,
            'detailBannerUploadFlag' => $detailBannerUploadFlag,
            'detailBannerUrl'        => $detailBannerUrl,
        ]);
    }

    /**
     * バナー情報の更新
     *
     * @param SiteManage\BannerRequest $request
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveBanner(SiteManage\BannerRequest $request, Orm\Site $site)
    {
        // 一覧用バナーがアップロードされる場合、ファイルを配置
        $listBannerUploadFlag = intval($request->get('list_banner_upload_flag'));
        switch ($listBannerUploadFlag) {
            case 0:     // なしにする
                Site\Banner::deleteListBanner($site);
                $site->list_banner_upload_flag = 0;
                $site->list_banner_url = '';
                break;
            case 1:
                Site\Banner::deleteListBanner($site);
                $site->list_banner_upload_flag = 1;
                $site->list_banner_url = $request->get('list_banner_url');
                break;
            case 2:
                Site\Banner::uploadListBannerFile($site, $request->file('list_banner_upload'));
                $site->list_banner_upload_flag = 2;
                break;
        }

        // 詳細用バナーがアップロードされる場合、ファイルを配置
        $detailBannerUploadFlag = intval($request->get('detail_banner_upload_flag'));
        switch ($detailBannerUploadFlag) {
            case 0:     // なしにする
                Site\Banner::deleteDetailBanner($site);
                $site->detail_banner_upload_flag = 0;
                $site->detail_banner_url = '';
                break;
            case 1:
                Site\Banner::deleteDetailBanner($site);
                $site->detail_banner_upload_flag = 1;
                $site->detail_banner_url = $request->get('detail_banner_url');
                break;
            case 2:
                Site\Banner::uploadDetailBannerFile($site, $request->file('detail_banner_upload'));
                $site->detail_banner_upload_flag = 2;
                break;
        }

        if ($listBannerUploadFlag != 3 || $detailBannerUploadFlag != 3) {
            $site->save();
            Site::registerUpdateTimeline(Auth::user(), $site);
        }

        return redirect()->route('サイト詳細', ['site' => $site->id]);
    }


    /**
     * 編集画面
     *
     * @param Orm\Site $site
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Orm\Site $site)
    {
        // 本人しか更新できない
        if ($site->user_id != Auth::id()) {
            return $this->forbidden(['site_id' => $site->id]);
        }

        return view('user.siteManage.edit', [
            'softs' => Orm\GameSoft::getPhoneticTypeHash(),
            'site'  => $site,
            'listBannerUploadFlag'   => old('list_banner_edit', 0),
            'detailBannerUploadFlag' => old('detail_banner_edit', 0)
        ]);
    }

    /**
     * データ更新
     *
     * @param SiteManage\UpdateRequest $request
     * @param Orm\Site $site
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update(SiteManage\UpdateRequest $request, Orm\Site $site)
    {
        // 本人しか更新できない
        if ($site->user_id != Auth::id()) {
            return $this->forbidden(['site_id' => $site->id]);
        }

        $this->setRequestData($site, $request);

        // 再投稿か削除の場合は、既存バナー削除するのでフラグを用意
        $isDeleteListBanner = $request->get('list_banner_edit') >= 2;
        $isDeleteDetailBanner = $request->get('detail_banner_edit') >= 2;

        $listBanner = $request->file('list_banner_upload');
        $detailBanner = $request->file('detail_banner_upload');

        $isDraft = $request->get('draft', 0) == 1;

        if (!Site::update(Auth::user(), $site, $listBanner, $detailBanner, $isDraft, $isDeleteListBanner, $isDeleteDetailBanner)) {
            session(['se' => 1]);
            return redirect()->back()->withInput();
        } else {
            Log::info('サイト更新成功' . Auth::id(), $request->toArray());
        }

        session(['u' => 1]);

        return redirect()->route('サイト詳細', ['site' => $site->id]);
    }

    /**
     * リクエストの値をO/Rマッパーにセット
     *
     * @param Orm\Site $site
     * @param $request
     */
    private function setRequestData(Orm\Site $site, $request)
    {
        $site->user_id = Auth::id();
        $site->name = $request->get('name', '');
        $site->url = $request->get('url', '');
        $site->presentation = $request->get('presentation', '');
        $site->main_contents_id = intval($request->get('main_contents', MainContents::OTHER));
        $site->rate = intval($request->get('rate',Rate::ALL));
        $site->gender = intval($request->get('gender', Gender::NONE));
        $site->handle_soft = $request->get('handle_soft');
    }

    /**
     * 削除
     *
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function delete(Orm\Site $site)
    {
        // 本人しか削除できない
        if ($site->user_id != Auth::id()) {
            return $this->forbidden(['site_id' => $site->id]);
        }

        if (Site::delete($site)) {
            Log::info('サイト削除成功' . Auth::id(), $site->toArray());
        }

        return redirect()->route('サイト管理');
    }

    /**
     * サイト更新履歴の登録
     *
     * @param Orm\Site $site
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addUpdateHistory(Orm\Site $site)
    {
        // 本人チェック
        if ($site->user_id != Auth::id()) {
            return $this->forbidden(['site_id' => $site->id]);
        }

        $updateHistory = new Orm\SiteUpdateHistory;
        $updateHistory->site_updated_at = date('Y-m-d');

        return view('user.siteManage.updateHistory', [
            'isEdit'        => false,
            'site'          => $site,
            'updateHistory' => $updateHistory
        ]);
    }

    /**
     * サイト更新履歴の登録処理
     *
     * @param UpdateHistoryRequest $request
     * @param Orm\Site $site
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function insertUpdateHistory(UpdateHistoryRequest $request, Orm\Site $site)
    {
        // 本人チェック
        if ($site->user_id != Auth::id()) {
            return $this->forbidden(['site_id' => $site->id]);
        }

        $siteUpdateHistory = new Orm\SiteUpdateHistory();
        $siteUpdateHistory->site_id = $site->id;
        $siteUpdateHistory->site_updated_at = $request->get('site_updated_at');
        $siteUpdateHistory->detail = $request->get('detail');

        Site::saveUpdateHistory($site, $siteUpdateHistory, $site->approval_status == ApprovalStatus::OK);

        return redirect()->route('サイト詳細', ['site' => $site->id]);
    }

    /**
     * サイト更新履歴の更新処理
     *
     * @param Orm\SiteUpdateHistory $siteUpdateHistory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editUpdateHistory(Orm\SiteUpdateHistory $siteUpdateHistory)
    {
        $site = Orm\Site::find($siteUpdateHistory->site_id);
        if ($site == null) {
            return abort(404);
        }

        // 本人チェック
        if ($site->user_id != Auth::id()) {
            return $this->forbidden(['site_id' => $site->id]);
        }

        return view('user.siteManage.updateHistory', [
            'isEdit'        => true,
            'site'          => $site,
            'updateHistory' => $siteUpdateHistory
        ]);
    }

    /**
     * サイト更新履歴の更新処理
     *
     * @param UpdateHistoryRequest $request
     * @param Orm\SiteUpdateHistory $siteUpdateHistory
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function updateUpdateHistory(UpdateHistoryRequest $request, Orm\SiteUpdateHistory $siteUpdateHistory)
    {
        $site = Orm\Site::find($siteUpdateHistory->site_id);
        if ($site == null) {
            return abort(404);
        }

        // 本人チェック
        if ($site->user_id != Auth::id()) {
            return $this->forbidden(['site_id' => $site->id]);
        }

        Site::saveUpdateHistory($site, $siteUpdateHistory, false);

        return redirect()->route('サイト詳細', ['site' => $site->id]);
    }

    /**
     * サイト更新履歴の削除
     *
     * @param Orm\SiteUpdateHistory $siteUpdateHistory
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteUpdateHistory(Orm\SiteUpdateHistory $siteUpdateHistory)
    {
        $site = Orm\Site::find($siteUpdateHistory->site_id);
        if ($site == null) {
            return abort(404);
        }

        // 本人チェック
        if ($site->user_id != Auth::id()) {
            return $this->forbidden(['site_id' => $site->id]);
        }

        $siteUpdateHistory->delete();

        return redirect()->route('サイト詳細', ['site' => $site->id]);
    }
}
