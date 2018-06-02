<?php
/**
 * 新着情報
 */

namespace Hgs3\Models\Timeline;

use Hgs3\Log;
use Hgs3\Models\User;
use Hgs3\Models\Orm;
use Illuminate\Pagination\LengthAwarePaginator;

class NewInformation extends TimelineAbstract
{
    /**
     * 新着情報タイムライン
     *
     * @param float $time
     * @param int $num
     * @return array
     */
    public static function get($time, $num)
    {
        $filter = [
            'time' => ['$lt' => $time]
        ];
        $options = [
            'sort'  => ['time' => -1],
            'limit' => $num,
        ];

        return self::getDB()->new_information->find($filter, $options)->toArray();
    }

    /**
     * ページ単位のデータを取得
     *
     * @param $page
     * @param $itemsPerPage
     * @return array
     */
    public static function getPage($page, $itemsPerPage)
    {
        $skip = ($page - 1) * $itemsPerPage;

        $options = [
            'sort'  => ['time' => -1],
            'limit' => $itemsPerPage,
            'skip'  => $skip
        ];

        $db = self::getDB();
        return $db->new_information->find([], $options)->toArray();
    }

    /**
     * データ数を取得
     *
     * @return int
     */
    public static function getNum()
    {
        return self::getDB()->new_information->count();
    }

    /**
     * 新着サイト
     *
     * @param Orm\Site $site
     * @throws \Exception
     */
    public static function addNewSiteText(Orm\Site $site)
    {
        $text = sprintf('新しいサイトが登録されました！<br><a href="%s">%s</a>',
            route('サイト詳細', ['site' => $site->id]),
            e($site->name)
        );

        self::insert($text);
    }

    /**
     * 更新サイト
     *
     * @param Orm\Site $site
     * @throws \Exception
     */
    public static function addUpdateSiteText(Orm\Site $site)
    {
        $text = sprintf('サイト「<a href="%s">%s</a>」のデータが更新されました！',
            route('サイト詳細', ['site' => $site->id]),
            e($site->name)
        );

        self::insert($text);
    }

    /**
     * 新しいゲーム
     *
     * @param Orm\GameSoft $soft
     * @throws \Exception
     */
    public static function addNewGameText(Orm\GameSoft $soft)
    {
        $text = sprintf('新しいホラーゲームを追加しました！<br><a href="%s">%s</a>',
            route('ゲーム詳細', ['soft' => $soft->id]),
            e($soft->name)
        );

        self::insert($text);
    }

    /**
     * 新しいゲーム
     *
     * @param Orm\GameSoft $soft
     * @throws \Exception
     */
    public static function addUpdateGameText(Orm\GameSoft $soft)
    {
        $text = sprintf('<a href="%s">%s</a>のデータを更新しました。',
            route('ゲーム詳細', ['soft' => $soft->id]),
            e($soft->name)
        );

        self::insert($text);
    }

    /**
     * 新しいレビュー
     *
     * @param Orm\GameSoft $soft
     * @param Orm\Review $review
     * @throws \Exception
     */
    public static function addNewReviewText(Orm\GameSoft $soft, Orm\Review $review)
    {
        $text = sprintf('<a href="%s">%sのレビュー</a>が投稿されました！',
            route('レビュー', ['review' => $review->id]),
            e($soft->name)
        );

        self::insert($text);
    }


    /**
     * データ登録
     *
     * @param $text
     * @return bool
     * @throws \Exception
     */
    private static function insert($text)
    {
        try {
            self::getDB()->new_information->insertOne([
                'text' => $text,
                'time' => microtime(true)
            ]);
        } catch (\Exception $e) {
            Log::exceptionError($e);
            return false;
        }

        return true;
    }
}