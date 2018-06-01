<?php
/**
 * ユーザー行動タイムラインモデル
 */

namespace Hgs3\Models;

use Hgs3\Constants\UserActionTimelineType;
use Hgs3\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserActionTimeline
{
    /**
     * @var User
     */
    private $user = null;

    /**
     * コンストラクタ
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * サインアップ
     */
    public function addSignUpText()
    {
        $text = sprintf('当サイトに参加しました！');

        $this->insert(UserActionTimelineType::SIGN_UP, $text);
    }

    /**
     * サイト登録
     *
     * @param User $followUser
     */
    public function addSiteText(User $followUser)
    {
        $text = sprintf(
            '<a href="%s">%sさん</a>をフォローしました。',
            route('プロフィール', ['showId' => $followUser->show_id]),
            $followUser->name
        );

        $this->insert(UserActionTimelineType::SIGN_UP, $text);
    }

    /**
     * MongoDBのコレクションを取得
     *
     * @return \MongoDB\Collection
     */
    public static function getMongoCollection()
    {
        $client = new \MongoDB\Client("mongodb://localhost:27017");
        return $client->hgs3->user_action_timeline;
    }

    /**
     * データ登録
     *
     * @param int $type
     * @param string $text
     * @param int $userOnly
     * @param array $option
     */
    private function insert($type, $text, $userOnly = 0, $option = [])
    {
        $data = [
            'type' => $type,
            'text' => $text,
            'user_id'   => $this->user->id,
            'user_only' => $userOnly,
            'time' => time()
        ];

        $collection = self::getMongoCollection();
        $collection->insertOne($data + $option);
    }
}