<?php
/**
 * ORM user_communities
 */

namespace Hgs3\Models\Orm;

use Hgs3\Constants\CreateTopicRole;
use Hgs3\User;
use Illuminate\Support\Facades\DB;

class UserCommunity extends \Eloquent
{
    //
    protected $guarded = ['id'];

    /**
     * メンバー一覧を取得
     *
     * @return \Illuminate\Support\Collection
     */
    public function getMembers()
    {
        return DB::table('user_community_members')
            ->where('user_community_id', $this->id)
            ->orderBy('join_at')
            ->get();
    }

    /**
     * デフォルトのユーザーコミュニティを作成
     *
     * @param User $user
     */
    public static function createDefault(User $user)
    {
        // トピックを作成
        $orm = new self;
        $orm->user_id = $user->id;
        $orm->name = '[運営]バグ報告';
        $orm->create_topic_type = CreateTopicRole::FREE;
        $orm->save();

        $topic = new UserCommunityTopic;
        $topic->user_community_id = $orm->id;
        $topic->user_id = $user->id;
        $topic->title = 'バグ報告';
        $topic->comment =<<< COMMENT
バグの報告はこちらにトピックを立ててください

・どのような問題が発生したか？
・いつごろ発生したか？
・どの画面で発生したか？
・お使いの機器(PC or スマホ)
・お使いの機器のOS(WindowsやiOSなど)
・お使いの機器のOSバージョン
・お使いのブラウザ
COMMENT;

        $topic->wrote_at = new \DateTime();
        $topic->response_at = new \DateTime();
        $topic->save();


    }
}
