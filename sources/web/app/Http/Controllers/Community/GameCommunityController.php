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
     * @param Game $game
     * @return $this
     */
    public function topics(Game $game)
    {
        $model = new \Hgs3\Models\Community\GameCommunity();

        $data = $model->getTopics($game->id);
        $data['game'] = $game;

        return view('community.game.topics')->with($data);
    }

    /**
     * トピックの詳細
     *
     * @param Game $game
     * @param GameCommunityTopic $gct
     * @return $this
     */
    public function topicDetail(Game $game, GameCommunityTopic $gct)
    {
        $model = new \Hgs3\Models\Community\GameCommunity();

        $data = $model->getTopicDetail($gct);
        $data['game'] = $game;
        $data['gct'] = $gct;
        $data['writer'] = User::find($gct->user_id);
        $data['csrfToken'] = csrf_token();
        $data['userId'] = Auth::id();

        return view('community.game.topic')->with($data);
    }

    /**
     * 投稿
     *
     * @param Topic $request
     * @param Game $game
     * @return \Illuminate\Http\RedirectResponse
     */
    public function write(Topic $request, Game $game)
    {
        // TODO: メンバーかどうか


        $title = $request->get('title');
        $comment = $request->get('comment');

        $model = new \Hgs3\Models\Community\GameCommunity();
        $model->writeTopic($game->id, Auth::id(), $title, $comment);

        return redirect()->back();
    }

    /**
     * レスの投稿
     *
     * @param TopicResponse $request
     * @param Game $game
     * @param GameCommunityTopic $gct
     * @return \Illuminate\Http\RedirectResponse
     */
    public function writeResponse(TopicResponse $request, Game $game, GameCommunityTopic $gct)
    {
        // TODO: メンバーかどうか

        $comment = $request->get('comment');

        $model = new \Hgs3\Models\Community\GameCommunity();
        $model->writeResponse($gct->id, Auth::id(), $comment);

        return redirect()->back();
    }

    /**
     * 投稿の削除
     *
     * @param Game $game
     * @param GameCommunityTopic $gct
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function erase(Game $game, GameCommunityTopic $gct)
    {
        // TODO: 投稿者かどうかチェック

        $gameId = $gct->game_id;

        $model = new \Hgs3\Models\Community\GameCommunity();
        $model->eraseTopic($gct->id);

        return redirect('community/g/' . $gameId . '/topics');
    }

    /**
     * レスの削除
     *
     * @param Game $game
     * @param GameCommunityTopicResponse $gctr
     * @return mixed
     */
    public function eraseResponse(Game $game, GameCommunityTopicResponse $gctr)
    {
        // TODO: 投稿者かどうかチェック

        $model = new \Hgs3\Models\Community\GameCommunity();
        $model->eraseTopicResponse($gctr);

        return redirect()->back();
    }
}
