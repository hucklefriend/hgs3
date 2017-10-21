<?php
/**
 * ユーザーコミュニティコントローラー
 */

namespace Hgs3\Http\Controllers\Community;

use Hgs3\Http\Requests\Community\User\Topic;
use Hgs3\Http\Requests\Community\User\TopicResponse;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserCommunityController extends Controller
{
    /**
     * コンストラクタ
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\View::share('navActive', 'community');
    }

    /**
     * ユーザーコミュニティトップページ
     *
     * @param Orm\UserCommunity $userCommunity
     * @return $this
     */
    public function detail(Orm\UserCommunity $userCommunity)
    {
        $uc = new \Hgs3\Models\Community\UserCommunity();

        $members = $uc->getOlderMembers($userCommunity->id);
        $topics = $uc->getLatestTopics($userCommunity->id);

        $users = User::getNameHash(array_merge(
            array_pluck($members->toArray(), 'user_id'),
            array_pluck($topics->toArray(), 'user_id')
        ));

        return view('community.user.detail', [
            'uc'       => $uc,
            'members'  => $members,
            'users'    => $users,
            'isMember' => $uc->isMember($userCommunity->id, Auth::id()),
            'topics'   => $topics
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
        $uc = new \Hgs3\Models\Community\UserCommunity();
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
        $model = new \Hgs3\Models\Community\UserCommunity();
        $model->secession($userCommunity, Auth::user());

        return redirect()->back();
    }

    /**
     * メンバー一覧
     *
     * @param Orm\UserCommunity $userCommunity
     * @return $this
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
     * @return $this
     */
    public function topics(Orm\UserCommunity $userCommunity)
    {
        $model = new \Hgs3\Models\Community\UserCommunity();

        $data = $model->getTopics($userCommunity->id);
        $data['uc'] = $userCommunity;

        return view('community.user.topics', $data);
    }

    /**
     * トピックの詳細
     *
     * @param Orm\UserCommunity $userCommunity
     * @param Orm\UserCommunityTopic $uct
     * @return $this
     */
    public function topicDetail(Orm\UserCommunity $userCommunity, Orm\UserCommunityTopic $uct)
    {
        $model = new \Hgs3\Models\Community\UserCommunity();

        $data = $model->getTopicDetail($uct);
        $data['uc'] = $userCommunity;
        $data['uct'] = $uct;
        $data['writer'] = User::find($uct->user_id);
        $data['csrfToken'] = csrf_token();
        $data['userId'] = Auth::id();

        return view('community.user.topic', $data);
    }

    /**
     * 投稿
     *
     * @param Topic $request
     * @param Orm\UserCommunity $userCommunity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function write(Topic $request, Orm\UserCommunity $userCommunity)
    {
        // TODO: メンバーかどうか


        $title = $request->get('title');
        $comment = $request->get('comment');

        $model = new \Hgs3\Models\Community\UserCommunity();
        $model->writeTopic($userCommunity, Auth::id(), $title, $comment);

        return redirect()->back();
    }

    /**
     * レスの投稿
     *
     * @param TopicResponse $request
     * @param Orm\UserCommunity $userCommunity
     * @param Orm\UserCommunityTopic $uct
     * @return \Illuminate\Http\RedirectResponse
     */
    public function writeResponse(TopicResponse $request, Orm\UserCommunity $userCommunity, Orm\UserCommunityTopic $uct)
    {
        // TODO: メンバーかどうか

        $comment = $request->get('comment');

        $model = new \Hgs3\Models\Community\UserCommunity();
        $model->writeResponse($uct->id, Auth::id(), $comment);

        return redirect()->back();
    }

    /**
     * 投稿の削除
     *
     * @param Orm\UserCommunity $userCommunity
     * @param Orm\UserCommunityTopic $uct
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function erase(Orm\UserCommunity $userCommunity, Orm\UserCommunityTopic $uct)
    {
        // TODO: 投稿者かどうかチェック

        $userCommunityId = $uct->user_community_id;

        $model = new \Hgs3\Models\Community\UserCommunity();
        $model->eraseTopic($uct->id);

        return redirect('community/u/' . $userCommunityId . '/topics');
    }

    /**
     * レスの削除
     *
     * @param Orm\UserCommunity $userCommunity
     * @param Orm\UserCommunityTopicResponse $uctr
     * @return mixed
     */
    public function eraseResponse(Orm\UserCommunity $userCommunity, Orm\UserCommunityTopicResponse $uctr)
    {
        // TODO: 投稿者かどうかチェック

        $model = new \Hgs3\Models\Community\UserCommunity();
        $model->eraseTopicResponse($uctr);

        return redirect()->back();
    }
}
