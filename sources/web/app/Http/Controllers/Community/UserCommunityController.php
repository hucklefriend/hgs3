<?php
/**
 * ユーザーコミュニティコントローラー
 */

namespace Hgs3\Http\Controllers\Community;

use Hgs3\Constants\PhoneticType;
use Hgs3\Constants\UserRole;
use Hgs3\Http\Requests\Game\Soft\UpdateRequest;
use Hgs3\Models\Orm\GameComment;
use Hgs3\Models\Orm\UserCommunity;
use Hgs3\Models\Orm\UserCommunityTopic;
use Hgs3\Models\User\FavoriteGame;
use Hgs3\User;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Game\Soft;
use Hgs3\Models\Orm\Game;
use Illuminate\Support\Facades\Auth;

class UserCommunityController extends Controller
{
    /**
     * ユーザーコミュニティトップページ
     *
     * @param UserCommunity $uc
     * @return $this
     */
    public function detail(UserCommunity $uc)
    {
        $model = new \Hgs3\Models\Community\UserCommunity();

        $members = $model->getOlderMembers($uc->id);
        $topics = $model->getLatestTopics($uc->id);

        $users = User::getNameHash(array_merge(
            array_pluck($members->toArray(), 'user_id'),
            array_pluck($topics->toArray(), 'user_id')
        ));

        return view('community.user.detail')->with([
            'uc'       => $uc,
            'members'  => $members,
            'users'    => $users,
            'isMember' => $model->isMember($uc->id, Auth::id()),
            'topics'   => $topics
        ]);
    }

    /**
     * 参加
     *
     * @param UserCommunity $uc
     * @return \Illuminate\Http\RedirectResponse
     */
    public function join(UserCommunity $uc)
    {
        $model = new \Hgs3\Models\Community\UserCommunity();
        $model->join($uc->id, Auth::id());

        return redirect()->back();
    }

    /**
     * 脱退
     *
     * @param UserCommunity $uc
     * @return \Illuminate\Http\RedirectResponse
     */
    public function secession(UserCommunity $uc)
    {
        $model = new \Hgs3\Models\Community\UserCommunity();
        $model->secession($uc->id, Auth::id());

        return redirect()->back();
    }

    /**
     * メンバー一覧
     *
     * @param UserCommunity $uc
     * @return $this
     */
    public function members(UserCommunity $uc)
    {
        $members = $uc->getMembers();

        return view('community.user.member')->with([
            'uc'      => $uc,
            'members' => $members,
            'users'   => User::getNameHash(array_pluck($members->toArray(), 'user_id'))
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

        return view('community.user.topic')->with($data);
    }

    public function write(UserCommunity $uc)
    {
        
    }

    public function remove(UserCommunity $uc)
    {

    }
}
