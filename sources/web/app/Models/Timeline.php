<?php
/**
 * タイムラインモデル
 */

namespace Hgs3\Models;

use Hgs3\Constants\TimelineType;
use Hgs3\Models\Orm\Game;
use Hgs3\Models\Orm\Review;
use Hgs3\Models\Orm\UserCommunity;
use Hgs3\Models\User\Mongo;
use Hgs3\User;
use Illuminate\Pagination\LengthAwarePaginator;

class Timeline
{
    // https://docs.mongodb.com/php-library/master/
    // http://qiita.com/_takwat/items/1d1463d22a1316a2efbe

    public function getMyPage($userId, $num)
    {
        $user = new Mongo($userId);

        $collection = self::getMongoCollection();

        $filter = [
            '$or' => [
                ['target_user_id' => 1],
                ['game_id' => ['$in' => $user->getFavoriteGame()]],
                ['user_id' => ['$in' =>$user->getFollow()]],
                ['site_id' => ['$in' =>$user->getFavoriteSite()]]
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
     * ゲームソフト追加
     *
     * @param $gameId
     * @param $gameName
     */
    public static function addNewGameSoftText($gameId, $gameName)
    {
        if ($gameName === null) {
            $gameName = self::getGameName($gameId);
            if ($gameName === false) {
                return;
            }
        }

        $text = sprintf('「<a href="%s">%s</a>」が追加されました。',
            url2('game/soft/' . $gameId),
            $gameName
        );

        self::insert(TimelineType::NEW_GAME_SOFT, $text, ['game_id' => $gameId]);
    }

    /**
     * ゲームソフト更新
     *
     * @param int $gameId
     * @param string $gameName
     */
    public static function addUpdateGameSoftText($gameId, $gameName)
    {
        if ($gameName === null) {
            $gameName = self::getGameName($gameId);
            if ($gameName === false) {
                return;
            }
        }

        $text = sprintf('「<a href="%s">%s</a>」の情報が更新されました。',
            url2('game/soft') . '/'.$gameId,
            $gameName
        );

        self::insert(TimelineType::UPDATE_GAME_SOFT, $text, ['game_id' => $gameId]);
    }

    /**
     * お気に入りゲーム登録
     *
     * @param $gameId
     * @param $gameName
     * @param $userId
     * @param $userName
     */
    public static function addFavoriteGameText($gameId, $gameName, $userId, $userName)
    {
        if ($gameName === null) {
            $gameName = self::getGameName($gameId);
            if ($gameName === false) {
                return;
            }
        }

        if ($userName === null) {
            $userName = self::getUserName($userId);
            if ($userName === false) {
                return;
            }
        }

        $text = sprintf('<a href="%s">%sさん</a>が<a href="%s">%s</a>をお気に入りゲームに登録しました。',
            url2('user/profile/' . $userId),
            $userName,
            url2('game/soft/' . $gameId),
            $gameName
        );

        self::insert(TimelineType::UPDATE_GAME_SOFT, $text, ['game_id' => $gameId]);
    }

    /**
     * レビュー投稿
     *
     * @param $reviewId
     * @param $userId
     * @param $userName
     * @param $gameId
     * @param $gameName
     */
    public static function addNewReviewText($reviewId, $userId, $userName, $gameId, $gameName)
    {
        if ($userName === null) {
            $userName = self::getUserName($userId);
            if ($userName === false) {
                return;
            }
        }

        if ($gameName === null) {
            $gameName = self::getGameName($gameId);
            if ($gameName === false) {
                return;
            }
        }

        $text = sprintf('<a href="%s">%s</a>さんが<a href="%s">%s</a>の<a href="%s">レビュー</a>を投稿しました。',
            url2('user/profile/' . $userId),
            $userName,
            url2('game/soft/' . $gameId),
            $gameName,
            url2('review/' . $reviewId)
        );

        self::insert(TimelineType::NEW_REVIEW, $text, [
            'user_id'   => $userId,
            'game_id'   => $gameId,
            'review_id' => $reviewId
        ]);
    }

    /**
     * レビューにイイネされた
     *
     * @param $reviewId
     * @param $userId
     * @param $userName
     * @param $reviewerId
     */
    public static function addReviewGoodText($reviewId, $userId, $userName, $reviewerId)
    {
        if ($userName === null) {
            $userName = self::getUserName($userId);
            if ($userName === false) {
                return;
            }
        }

        if ($reviewerId === null) {
            $r = Review::find($reviewId);
            $reviewId = $r->user_id;
        }

        $text = sprintf('<a href="%s">投稿したレビュー</a>に<a href="%s">%sさん</a>がイイネしました！',
            url2('review/' . $reviewId),
            url2('user/profile/' . $userId),
            $userName
        );

        self::insert(TimelineType::REVIEW_GOOD, $text, [
            'target_user_id' => $reviewerId,
            'review_id'      => $reviewId
        ]);
    }

    /**
     * ユーザーコミュニティに新メンバー
     *
     * @param $communityId
     * @param $communityName
     * @param $userId
     * @param $userName
     */
    public static function addNewUserCommunityMemberText($communityId, $communityName, $userId, $userName)
    {
        if ($userName === null) {
            $userName = self::getUserName($userId);
            if ($userName === false) {
                return;
            }
        }

        if ($communityName === null) {
            $communityName = self::getCommunityName($communityId);
            if ($communityName === false) {
                return;
            }
        }

        $text = sprintf('コミュニティ「<a href="%s">%s</a>」に<a href="%s">%sさん</a>が参加しました',
            url2('community/u/' . $communityId),
            $communityName,
            url2('user/profile/' . $userId),
            $userName
        );

        self::insert(TimelineType::NEW_USER_COMMUNITY_MEMBER, $text, [
            'community_id' => $communityId,
            'user_id'      => $userId
        ]);
    }

    /**
     * ゲームコミュニティに新メンバー
     *
     * @param $communityId
     * @param $communityName
     * @param $userId
     * @param $userName
     */
    public static function addNewGameCommunityMemberText($communityId, $communityName, $userId, $userName)
    {
        if ($userName === null) {
            $userName = self::getUserName($userId);
            if ($userName === false) {
                return;
            }
        }

        if ($communityName === null) {
            $communityName = self::getGameName($communityId);
            if ($communityName === false) {
                return;
            }
        }

        $text = sprintf('コミュニティ「<a href="%s">%s</a>」に<a href="%s">%sさん</a>が参加しました',
            url2('community/g') . '/' . $communityId,
            $communityName,
            url2('user/profile') . '/' . $userId,
            $userName
        );

        self::insert(TimelineType::NEW_USER_COMMUNITY_MEMBER, $text, [
            'community_id' => $communityId,
            'user_id'      => $userId
        ]);
    }

    /**
     * フォローされた
     *
     * @param $followerId
     * @param $followerName
     * @param $userId
     */
    public static function addNewFollower($followerId, $followerName, $userId)
    {
        if ($followerName === null) {
            $followerName = self::getUserName($followerId);
            if ($followerName === false) {
                return;
            }
        }

        $text = sprintf('<a href="%s">%sさん</a>にフォローされました',
            url2('user/profile/' . $followerId),
            $followerName
        );

        self::insert(TimelineType::NEW_USER_COMMUNITY_MEMBER, $text, [
            'target_user_id' => $userId
        ]);
    }

    /**
     * 新規サイトを登録
     *
     * @param int $userId
     * @param string $userName
     * @param int $siteId
     * @param string $siteName
     */
    public static function addNewSite($userId, $userName, $siteId, $siteName)
    {
        if ($userName === null) {
            $userName = self::getUserName($userId);
            if ($userName === false) {
                return;
            }
        }

        if ($siteName === null) {
            $siteName = self::getSiteName($siteId);
            if ($siteName === false) {
                return;
            }
        }

        $text = sprintf('<a href="%s">%sさん</a>がサイト「<a href="%s">%s</a>」を登録しました',
            url2('user/profile/' . $userId),
            $userName,
            url2('site/detail/' . $siteId),
            $siteName
        );

        self::insert(TimelineType::NEW_SITE, $text, [
            'user_id' => $userId
        ]);
    }

    /**
     * 更新サイトを登録
     *
     * @param int $userId
     * @param string $userName
     * @param int $siteId
     * @param string $siteName
     */
    public static function addUpdateSite($userId, $userName, $siteId, $siteName)
    {
        if ($userName === null) {
            $userName = self::getUserName($userId);
            if ($userName === false) {
                return;
            }
        }

        if ($siteName === null) {
            $siteName = self::getSiteName($siteId);
            if ($siteName === false) {
                return;
            }
        }

        $text = sprintf('<a href="%s">%sさん</a>のサイト「<a href="%s">%s</a>」の情報が更新されました',
            url2('user/profile/' . $userId),
            $userName,
            url2('site/detail/' . $siteId),
            $siteName
        );

        self::insert(TimelineType::NEW_SITE, $text, [
            'user_id' => $userId
        ]);
    }

    /**
     * MongoDBのコレクションを取得
     *
     * @return \MongoDB\Collection
     */
    public static function getMongoCollection()
    {
        $client = new \MongoDB\Client("mongodb://localhost:27017");
        return $client->hgs3->timeline;
    }

    /**
     * データ登録
     *
     * @param int $type
     * @param string $text
     * @param array $option
     */
    private static function insert($type, $text, $option = [])
    {
        $data = [
            'type' => $type,
            'text' => $text,
            'time' => time()
        ];

        $collection = self::getMongoCollection();
        $collection->insertOne($data + $option);
    }

    /**
     * ゲーム名を取得
     *
     * @param $gameId
     * @return bool|mixed
     */
    private static function getGameName($gameId)
    {
        $game = Game::find($gameId);
        if ($game !== null) {
            return $game->name;
        }

        return false;
    }

    /**
     * サイト名を取得
     *
     * @param $gameId
     * @return bool|mixed
     */
    private static function getSiteName($siteId)
    {
        $site = \Hgs3\Models\Orm\Site::find($siteId);
        if ($site !== null) {
            return $site->name;
        }

        return false;
    }

    /**
     * ユーザー名を取得
     *
     * @param $userId
     * @return bool|mixed
     */
    private static function getUserName($userId)
    {
        $user = User::find($userId);
        if ($user !== null) {
            return $user->name;
        }

        return false;
    }

    /**
     * コミュニティ名を取得
     *
     * @param $communityId
     * @return bool|mixed
     */
    private static function getCommunityName($communityId)
    {
        $community = UserCommunity::find($communityId);
        if ($community !== null) {
            return $community->name;
        }

        return false;
    }
}