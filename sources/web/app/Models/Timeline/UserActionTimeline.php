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
     * マイページ
     *
     * @param $userId
     * @param $num
     * @return array
     */
    public function getMyPage($userId, $num)
    {
        $collection = self::getMongoCollection();

        $filter = [
            '$or' => [
                ['target_user_id' => 1],
                ['game_id' => ['$in' => $this->user->getFavoriteGame()]],
                ['user_id' => ['$in' => $this->user->getFollow()]],
                ['site_id' => ['$in' => $this->user->getFavoriteSite()]]
            ],
            'user_id' => ['$ne' => 1]
        ];

        $itemNum = $collection->count($filter);

        $pager = new LengthAwarePaginator([], $itemNum, $num);
        $pager->setPath('');

        $options = [
            'sort'  => ['time' => -1],
            'limit' => $num,
            'skip'  => ($pager->currentPage() - 1) * $num
        ];

        return [
            'pager'     => $pager,
            'timelines' => $collection->find($filter, $options)
        ];
    }

    /**
     * サインアップ
     */
    public function addSignUpText()
    {
        $text = sprintf('H.G.N.に参加しました！');

        $this->insert(UserActionTimelineType::SIGN_UP, $text);
    }

    /**
     * フォロー
     *
     * @param User $followUser
     */
    public function addFollowText(User $followUser)
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
     * @param array $option
     */
    private function insert($type, $text, $option = [])
    {
        $data = [
            'type' => $type,
            'text' => $text,
            'user_id' => $this->user->id,
            'time' => time()
        ];

        $collection = self::getMongoCollection();
        $collection->insertOne($data + $option);
    }
}