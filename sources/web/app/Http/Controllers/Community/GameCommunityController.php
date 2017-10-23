<?php
/**
 * ゲームコミュニティコントローラー
 */

namespace Hgs3\Http\Controllers\Community;

use Hgs3\Constants\PhoneticType;
use Hgs3\Constants\UserRole;
use Hgs3\Http\Requests\Community\User\WriteTopicRequest;
use Hgs3\Http\Requests\Community\User\WriteResponseRequest;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\Community\GameCommunity;
use Illuminate\Support\Facades\Auth;

class GameCommunityController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'community');
    }

    /**
     * 一覧ページ
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $soft = new Soft;
        $gc = new GameCommunity;

        return view('community.game.index', [
            'phoneticList' => PhoneticType::getId2CharData(),
            'list'         => $soft->getList(),
            'memberNum'    => $gc->getMemberNum()
        ]);
    }

    /**
     * ゲームコミュニティトップページ
     *
     * @param Orm\GameSoft $soft
     * @return $this
     */
    public function detail(Orm\GameSoft $soft)
    {
        $gc = new GameCommunity();
        $package = Orm\GamePackage::find($soft->original_package_id);

        $members = $gc->getOlderMembers($soft->id);
        $topics = $gc->getLatestTopics($soft->id);

        $users = User::getNameHash(array_merge(
            array_pluck($members->toArray(), 'user_id'),
            array_pluck($topics->toArray(), 'user_id')
        ));

        $gameCommunity = Orm\GameCommunity::find($soft->id);

        return view('community.game.detail', [
            'soft'      => $soft,
            'package'   => $package,
            'memberNum' => $gameCommunity ? $gameCommunity->user_num : 0,
            'members'   => $members,
            'users'     => $users,
            'isMember'  => $gc->isMember($soft->id, Auth::id()),
            'topics'    => $topics
        ]);
    }

    /**
     * 参加
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Http\RedirectResponse
     */
    public function join(Orm\GameSoft $soft)
    {
        $gc = new GameCommunity();
        $gc->join($soft, Auth::user());

        return redirect()->back();
    }

    /**
     * 脱退
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leave(Orm\GameSoft $soft)
    {
        $gc = new GameCommunity();
        $gc->leave($soft, Auth::user());

        return redirect()->back();
    }

    /**
     * メンバー一覧
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function members(Orm\GameSoft $soft)
    {
        $gc = new GameCommunity;

        $members = $gc->getMembers($soft);

        $package = Orm\GamePackage::find($soft->original_package_id);

        return view('community.game.member', [
            'soft'     => $soft,
            'package'  => $package,
            'members'  => $members,
            'users'    => User::getNameHash($members->toArray()),
            'isMember' => $gc->isMember($soft->id, Auth::id())
        ]);
    }

    /**
     * トピックス
     *
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function topics(Orm\GameSoft $soft)
    {
        $gc = new GameCommunity();

        $data = $gc->getTopics($soft->id);
        $data['soft'] = $soft;
        $data['package'] = Orm\GamePackage::find($soft->original_package_id);
        $data['isMember'] = $gc->isMember($soft->id, Auth::id());

        return view('community.game.topics', $data);
    }

    /**
     * トピックの詳細
     *
     * @param Orm\GameSoft $soft
     * @param Orm\GameCommunityTopic $topic
     * @return $this
     */
    public function topicDetail(Orm\GameSoft $soft, Orm\GameCommunityTopic $topic)
    {
        $gc = new GameCommunity();

        $data = $gc->getTopicDetail($topic);
        $data['soft'] = $soft;
        $data['topic'] = $topic;
        $data['writer'] = User::find($topic->user_id);
        $data['csrfToken'] = csrf_token();
        $data['userId'] = Auth::id();
        $data['package'] = Orm\GamePackage::find($soft->original_package_id);
        $data['isMember'] = $gc->isMember($soft->id, Auth::id());

        return view('community.game.topic', $data);
    }

    /**
     * 投稿
     *
     * @param WriteTopicRequest $request
     * @param Orm\GameSoft $soft
     * @return \Illuminate\Http\RedirectResponse
     */
    public function write(WriteTopicRequest $request, Orm\GameSoft $soft)
    {
        $gc = new GameCommunity();

        // メンバーかどうか
        if (!$gc->isMember($soft->id, Auth::id())) {
            return abort(403);
        }

        $title = $request->get('title');
        $comment = $request->get('comment');

        $gc->writeTopic($soft, Auth::user(), $title, $comment);

        return redirect()->back();
    }

    /**
     * レスの投稿
     *
     * @param WriteResponseRequest $request
     * @param Orm\GameSoft $soft
     * @param Orm\GameCommunityTopic $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function writeResponse(WriteResponseRequest $request, Orm\GameSoft $soft, Orm\GameCommunityTopic $topic)
    {
        $gc = new GameCommunity();

        // メンバーかどうか
        if (!$gc->isMember($soft->id, Auth::id())) {
            return abort(403);
        }

        $comment = $request->get('comment');

        $gc->writeResponse($topic, Auth::user(), $comment);

        return redirect()->back();
    }

    /**
     * 投稿の削除
     *
     * @param Orm\GameSoft $soft
     * @param Orm\GameCommunityTopic $res
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function erase(Orm\GameSoft $soft, Orm\GameCommunityTopic $res)
    {
        // 管理人または投稿者かどうかチェック
        if (!UserRole::isAdmin() || $res->user_id != Auth::id()) {
            return abort(403);
        }

        $gc = new GameCommunity();
        $gc->eraseTopic($res);

        return redirect('community/g/' . $soft->id . '/topics');
    }

    /**
     * レスの削除
     *
     * @param Orm\GameSoft $soft
     * @param Orm\GameCommunityTopicResponse $res
     * @return mixed
     */
    public function eraseResponse(Orm\GameSoft $soft, Orm\GameCommunityTopicResponse $res)
    {
        // 管理人または投稿者かどうかチェック
        if (!UserRole::isAdmin() || $res->user_id != Auth::id()) {
            return abort(403);
        }

        $gc = new GameCommunity();
        $gc->eraseTopicResponse($res);

        return redirect()->back();
    }
}
