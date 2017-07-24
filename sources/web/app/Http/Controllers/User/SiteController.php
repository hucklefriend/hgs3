<?php
/**
 * ユーザーのサイトコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Requests\User\Site\AddRequest;
use Hgs3\Http\Requests\User\Site\UpdateRequest;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\Site;
use Hgs3\User;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    /**
     * サイトページ
     *
     * @param User $user
     * @return $this|SiteController
     */
    public function index(User $user)
    {
        // ログインユーザー本人の場合は、自身のサイトページへ
        if ($user->id == Auth::id()) {
            return $this->myself();
        }

        return view('user.site.index')->with([
        ]);
    }

    /**
     * 自身の管理サイトを表示
     *
     * @return $this
     */
    public function myself()
    {
        return view('user.site.myself')->with([
            'sites' => Site::where('user_id', Auth::id())->get()
        ]);
    }

    /**
     * サイト詳細
     *
     * @param Site $site
     */
    public function detail(Site $site)
    {
        return view('site.detail')->with([
            'site' => $site,
        ]);
    }

    /**
     * 追加入力ページ
     */
    public function add()
    {
        $soft = new Soft;

        return view('user.site.add')->with([
            'games' => $soft->getList()
        ]);
    }

    /**
     * サイト追加
     *
     * @param AddRequest $request
     * @return $this
     */
    public function store(AddRequest $request)
    {
        $site = new Site;

        $site->user_id = Auth::id();
        $site->name = $request->get('name') ?? '';
        $site->url = $request->get('url') ?? '';
        $site->banner_url = $request->get('banner_url') ?? '';
        $site->presentation = $request->get('presentation') ?? '';
        $site->main_contents_id = intval($request->get('main_contents') ?? 0);
        $site->rate = intval($request->get('rate') ?? 1);
        $site->gender = intval($request->get('gender') ?? 1);
        $site->open_type = 0;
        $site->in_count = 0;
        $site->out_count = 0;
        $site->good_count = 0;
        $site->bad_count = 0;
        $site->registered_timestamp = time();
        $site->updated_timestamp = 0;

        $siteId = $site->saveWithHandleGame($request->get('handle_game') ?? '');
        if ($siteId === false) {
            // TODO エラー
        }

        return view('user.site.add_complete')->with([
            'site_id' => $siteId
        ]);
    }

    /**
     * 編集画面
     *
     * @param Site $site
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Site $site)
    {
        if ($site->user_id != Auth::id()) {
            // 他人のサイトを編集しようとした
            return view('user.site.edit_error');
        } else {
            $soft = new Soft;
            return view('user.site.edit')->with([
                'soft' => $soft->getList()
            ]);
        }
    }

    /**
     * 編集
     *
     * @param UpdateRequest $request
     * @param Site $site
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(UpdateRequest $request, Site $site)
    {
        if ($site->user_id != Auth::id()) {
            // 他人のサイトを編集しようとした
            return view('user.site.edit_error');
        } else {
            $site->user_id = Auth::id();
            $site->name = $request->get('name') ?? '';
            $site->url = $request->get('url') ?? '';
            $site->banner_url = $request->get('banner_url') ?? '';
            $site->presentation = $request->get('presentation') ?? '';
            $site->main_contents_id = intval($request->get('main_contents') ?? 0);
            $site->rate = intval($request->get('rate') ?? 1);
            $site->gender = intval($request->get('gender') ?? 1);
            $site->updated_timestamp = time();

            return redirect('/site/detail/' . $site->id);
        }
    }

    /**
     * サイト遷移
     *
     * @param Site $site
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function go(Site $site)
    {
        // TODO アクセスログに保存

        return redirect($site->url);
    }
}
