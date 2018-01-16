<?php
/**
 * ユーザーコミュニティコントローラー
 */

namespace Hgs3\Http\Controllers\Community;

use Hgs3\Constants\UserRole;
use Hgs3\Http\Requests\Community\User\WriteTopicRequest;
use Hgs3\Http\Requests\Community\User\WriteResponseRequest;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Hgs3\Models\Community\UserCommunity;

class UserCommunityController extends Controller
{
    /**
     * ユーザーコミュニティトップページ
     *
     * @param Orm\UserCommunity $userCommunity
     * @return $this
     */
    public function detail(Orm\UserCommunity $userCommunity)
    {
        $uc = new UserCommunity();

        $members = $uc->getOlderMembers($userCommunity->id);
        $topics = $uc->getLatestTopics($userCommunity->id);

        $users = User::getNameHash(array_merge(
            array_pluck($members->toArray(), 'user_id'),
            array_pluck($topics->toArray(), 'user_id')
        ));

        return view('community.user.detail', [
            'userCommunity' => $userCommunity,
            'members'       => $members,
            'users'         => $users,
            'isMember'      => $uc->isMember($userCommunity->id, Auth::id()),
            'topics'        => $topics
        ]);
    }

    /**
     * 参加
     *
     * @param Orm\UserCommunity $uc
     * @return \Illuminate\Http\RedirectResponse
     */
    public function join(Orm\UserCommunity $userCommunity)
    {
        $uc = new UserCommunity();
        $uc->join($userCommunity, Auth::user());

        return redirect()->back();
    }

    /**
     * 脱退
     *
     * @param Orm\UserCommunity $userCommunity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function secession(Orm\UserCommunity $userCommunity)
    {
        $uc = new UserCommunity();
        $uc->leave($userCommunity, Auth::user());

        return redirect()->back();
    }

    /**
     * メンバー一覧
     *
     * @param Orm\UserCommunity $userCommunity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function members(Orm\UserCommunity $userCommunity)
    {
        $members = $userCommunity->getMembers();

        return view('community.user.member', [
            'uc'      => $userCommunity,
            'members' => $members,
            'users'   => User::getNameHash(array_pluck($members->toArray(), 'user_id'))
        ]);
    }

    /**
     * トピックス
     *
     * @param Orm\UserCommunity $userCommunity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function topics(Orm\UserCommunity $userCommunity)
    {
        $uc = new UserCommunity();

        $data = $uc->getTopics($userCommunity->id);
        $data['userCommunity'] = $userCommunity;

        return view('community.user.topics', $data);
    }

    /**
     * トピックの詳細
     *
     * @param Orm\UserCommunity $userCommunity
     * @param Orm\UserCommunityTopic $topic
     * @return $this
     */
    public function topicDetail(Orm\UserCommunity $userCommunity, Orm\UserCommunityTopic $topic)
    {
        $uc = new UserCommunity();

        $data = $uc->getTopicDetail($topic);
        $data['userCommunity'] = $userCommunity;
        $data['topic'] = $topic;
        $data['writer'] = User::find($topic->user_id);
        $data['csrfToken'] = csrf_token();
        $data['userId'] = Auth::id();

        return view('community.user.topic', $data);
    }

    /**
     * 投稿
     *
     * @param WriteTopicRequest $request
     * @param Orm\UserCommunity $userCommunity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function write(WriteTopicRequest $request, Orm\UserCommunity $userCommunity)
    {
        $uc = new UserCommunity();

        // メンバーかどうか
        if (!$uc->isMember($userCommunity->id, Auth::id())) {
            return abort(403);
        }

        $title = $request->get('title');
        $comment = $request->get('comment');

        $uc->writeTopic($userCommunity, Auth::id(), $title, $comment);

        return redirect()->back();
    }

    /**
     * レスの投稿
     *
     * @param WriteResponseRequest $request
     * @param Orm\UserCommunity $userCommunity
     * @param Orm\UserCommunityTopic $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function writeResponse(WriteResponseRequest $request, Orm\UserCommunity $userCommunity, Orm\UserCommunityTopic $topic)
    {
        $uc = new UserCommunity();

        // メンバーかどうか
        if (!$uc->isMember($userCommunity->id, Auth::id())) {
            return abort(403);
        }

        $comment = $request->get('comment');

        $uc->writeResponse($topic, Auth::user(), $comment);

        return redirect()->back();
    }

    /**
     * 投稿の削除
     *
     * @param Orm\UserCommunity $userCommunity
     * @param Orm\UserCommunityTopic $topic
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function erase(Orm\UserCommunity $userCommunity, Orm\UserCommunityTopic $topic)
    {
        // 管理人または投稿者かどうかチェック
        if (!UserRole::isAdmin() || $topic->user_id != Auth::id()) {
            return abort(403);
        }

        $uc = new UserCommunity();
        $uc->eraseTopic($topic->id);

        return redirect('community/u/' . $topic->user_community_id . '/topics');
    }

    /**
     * レスの削除
     *
     * @param Orm\UserCommunity $userCommunity
     * @param Orm\UserCommunityTopicResponse $res
     * @return mixed
     */
    public function eraseResponse(Orm\UserCommunity $userCommunity, Orm\UserCommunityTopicResponse $res)
    {
        // 管理人または投稿者かどうかチェック
        if (!UserRole::isAdmin() || $res->user_id != Auth::id()) {
            return abort(403);
        }

        $uc = new UserCommunity();
        $uc->eraseTopicResponse($res);

        return redirect()->back();
    }
}
