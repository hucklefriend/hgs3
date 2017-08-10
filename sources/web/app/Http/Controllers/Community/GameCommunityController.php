<?php
/**
 * ゲームコミュニティコントローラー
 */

namespace Hgs3\Http\Controllers\Community;

use Hgs3\Constants\PhoneticType;
use Hgs3\Constants\UserRole;
use Hgs3\Http\Requests\Community\User\Topic;
use Hgs3\Http\Requests\Community\User\TopicResponse;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\GameComment;
use Hgs3\Models\Orm\GameCommunity;
use Hgs3\Models\Orm\GameCommunityTopic;
use Hgs3\Models\Orm\GameCommunityTopicResponse;
use Hgs3\User;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Soft;
use Illuminate\Support\Facades\Auth;

class GameCommunityController extends Controller
{
    /**
     * 一覧ページ
     */
    public function index()
    {
        $soft = new Soft;

        $gc = new \Hgs3\Models\Community\GameCommunity;

        return view('community.game.index')->with([
            'phoneticList' => PhoneticType::getId2CharData(),
            'list'         => $soft->getList(),
            'memberNum'    => $gc->getMemberNum()
        ]);
    }

    /**
     * ゲームコミュニティトップページ
     *
     * @param Game $game
     * @return $this
     */
    public function detail(Game $game)
    {
        $model = new \Hgs3\Models\Community\GameCommunity();

        $members = $model->getOlderMembers($game->id);
        $topics = $model->getLatestTopics($game->id);

        $users = User::getNameHash(array_merge(
            array_pluck($members->toArray(), 'user_id'),
            array_pluck($topics->toArray(), 'user_id')
        ));

        $gc = GameCommunity::find($game->id);

        return view('community.game.detail')->with([
            'game'       => $game,
            'memberNum'  => $gc ? $gc->user_num : 0,
            'members'    => $members,
            'users'      => $users,
            'isMember'   => $model->isMember($game->id, Auth::id()),
            'topics'     => $topics
        ]);
    }

    /**
     * 参加
     *
     * @param Game $game
     * @return \Illuminate\Http\RedirectResponse
     */
    public function join(Game $game)
    {
        $model = new \Hgs3\Models\Community\GameCommunity();
        $model->join($game->id, Auth::id());

        return redirect()->back();
    }

    /**
     * 脱退
     *
     * @param Game $game
     * @return \Illuminate\Http\RedirectResponse
     */
    public function secession(Game $game)
    {
        $model = new \Hgs3\Models\Community\GameCommunity();
        $model->secession($game->id, Auth::id());

        return redirect()->back();
    }

    /**
     * メンバー一覧
     *
     * @param Game $game
     * @return $this
     */
    public function members(Game $game)
    {
        $gc = new \Hgs3\Models\Community\GameCommunity;

        $members = $gc->getMembers($game);

        return view('community.game.member')->with([
            'game'    => $game,
            'members' => $members,
            'users'   => User::getNameHash($members)
        ]);
    }

    /**
     * トピックス
     *
     * @param UserCommunity $uc
     * @return $this
     */
    public function topics(UserCommunity $uc)
    {
        $model = new \Hgs3\Models\Community\UserCommunity();

        $data = $model->getTopics($uc->id);
        $data['uc'] = $uc;

        return view('community.user.topics')->with($data);
    }

    /**
     * トピックの詳細
     *
     * @param UserCommunity $uc
     * @param UserCommunityTopic $uct
     * @return $this
     */
    public function topicDetail(UserCommunity $uc, UserCommunityTopic $uct)
    {
        $model = new \Hgs3\Models\Community\UserCommunity();

        $data = $model->getTopicDetail($uct);
        $data['uc'] = $uc;
        $data['uct'] = $uct;
        $data['writer'] = User::find($uct->user_id);
        $data['csrfToken'] = csrf_token();
        $data['userId'] = Auth::id();

        return view('community.user.topic')->with($data);
    }

    /**
     * 投稿
     *
     * @param Topic $request
     * @param UserCommunity $uc
     * @return \Illuminate\Http\RedirectResponse
     */
    public function write(Topic $request, UserCommunity $uc)
    {
        // TODO: メンバーかどうか


        $title = $request->get('title');
        $comment = $request->get('comment');

        $model = new \Hgs3\Models\Community\UserCommunity();
        $model->writeTopic($uc->id, Auth::id(), $title, $comment);

        return redirect()->back();
    }

    /**
     * レスの投稿
     *
     * @param TopicResponse $request
     * @param UserCommunity $uc
     * @param UserCommunityTopic $uct
     * @return \Illuminate\Http\RedirectResponse
     */
    public function writeResponse(TopicResponse $request, UserCommunity $uc, UserCommunityTopic $uct)
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
     * @param UserCommunity $uc
     * @param UserCommunityTopic $uct
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function erase(UserCommunity $uc, UserCommunityTopic $uct)
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
     * @param UserCommunity $uc
     * @param UserCommunityTopicResponse $uctr
     * @return mixed
     */
    public function eraseResponse(UserCommunity $uc, UserCommunityTopicResponse $uctr)
    {
        // TODO: 投稿者かどうかチェック

        $model = new \Hgs3\Models\Community\UserCommunity();
        $model->eraseTopicResponse($uctr);

        return redirect()->back();
    }
}
