<?php

/**
 * Class グローバルバック管理
 */

namespace Hgs3\Http;

use Hgs3\Constants\PageId;
use Hgs3\Constants\Site\ApprovalStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Hgs3\Models\Orm;

class GlobalBack
{
    const SESSION_KEY = 'global_back';
    const MAX_HISTORY_NUM = 5;

    const MY_PAGE_GROUP = [
        PageId::USER_TIMELINE,
        PageId::USER_FAVORITE_GAME,
        PageId::USER_GOOD_SITE,
        PageId::USER_FAVORITE_SITE,
        PageId::USER_FOLLOW,
        PageId::USER_FOLLOWER,
        PageId::USER_PROFILE,
        PageId::USER_REVIEW,
        PageId::USER_REVIEW_DRAFT,
        PageId::USER_SITE,
        PageId::USER_MESSAGE,
        PageId::USER_MESSAGE_SENT
    ];

    const FRIEND_PAGE_GROUP = [
        PageId::FRIEND_TIMELINE,
        PageId::FRIEND_FAVORITE_GAME,
        PageId::FRIEND_FAVORITE_SITE,
        PageId::FRIEND_SITE,
        PageId::FRIEND_FOLLOW,
        PageId::FRIEND_FOLLOWER,
        PageId::FRIEND_PROFILE,
        PageId::FRIEND_REVIEW
    ];

    /**
     * 履歴を消す
     */
    public static function clear()
    {
        session()->forget(self::SESSION_KEY);
    }

    /**
     * 履歴追加
     *
     * @param $pageId
     * @param null $option
     */
    public static function push($pageId, $option = null)
    {
        $history = session(self::SESSION_KEY);

        $item = [$pageId, Request::fullUrlWithQuery(['gb' => 1]), $option];

        $num = empty($history) ? 0 : count($history);
        if ($num > 0) {
            // GBで戻って来た場合、直近の自分があるか探す
            if (Request::query('gb', false) !== false) {
                $found = false;
                for ($i = 0; $i < $num; $i++) {
                    if (self::isSamePage($history[$i][0], $pageId)) {
                        $found = true;

                        // 自分があったらそこを上書き
                        $history[$i] = $item;

                        // そこに至るまでを削除
                        if ($i > 0) {
                            $history = array_slice($history, $i);
                        }

                        break;
                    }
                }

                if (!$found) {
                    // なければ頭に追加
                    array_unshift($history, $item);
                }
            } else {
                if (self::isSamePage($history[0][0], $pageId)) {
                    // 直前が同じ画面だったら上書き
                    $history[0] = $item;
                } else {
                    // そうでなければ頭に追加
                    array_unshift($history, $item);
                }
            }
        } else {
            $history = [$item];
        }

        if (count($history) > self::MAX_HISTORY_NUM) {
            // 最大保持数を超えていたら1つ削除
            array_pop($history);
        }

        session([self::SESSION_KEY => $history]);
    }

    /**
     * 同じ(と扱う)画面かチェック
     *
     * @param $historyPageId
     * @param $pageId
     * @return bool
     */
    private static function isSamePage($historyPageId, $pageId)
    {
        if (in_array($pageId, self::MY_PAGE_GROUP)) {
            return in_array($historyPageId, self::MY_PAGE_GROUP);
        } else if (in_array($pageId, self::FRIEND_PAGE_GROUP)) {
            return in_array($historyPageId, self::FRIEND_PAGE_GROUP);
        } else {
            return $pageId == $historyPageId;
        }
    }

    /**
     * 1つ前のページ
     */
    public static function before()
    {
        $history = session(self::SESSION_KEY);

        $i = 0;
        if (Request::query('gb', false) !== false) {
            $i = 1;
        }

        if (isset($history[$i])) {
            return $history[$i];
        }

        return false;
    }

    /**
     * さかのぼって、指定のページがあるか
     *
     * @param array $pageId
     * @return bool
     */
    public static function beforeHas(array $pageId)
    {
        $history = session(self::SESSION_KEY);

        $i = 0;
        if (Request::query('gb', false) !== false) {
            $i = 1;
        }

        if (!empty($history)) {
            $num = count($history);
            for (; $i < $num; $i++) {
                if (in_array($history[$i][0], $pageId)) {
                    return $history[$i];
                }
            }
        }

        return false;
    }

    /**
     * 履歴を作りつつ、リンクを生成
     *
     * @param $pageId
     * @param $clearHistory
     * @param $name
     * @param array $parameters
     * @return string
     */
    public static function createLink($pageId, $clearHistory, $name, $parameters = [])
    {
        if ($pageId !== null) {
            self::push($pageId);
        }
        if ($clearHistory) {
            self::clear();
        }

        return self::route($name, $parameters);
    }

    /**
     * グローバルバック用のrouteヘルパー
     *
     * @param $name
     * @param array $parameters
     * @param bool $absolute
     * @return string
     */
    public static function route($name, $parameters = [], $absolute = true)
    {
        return route($name, $parameters, $absolute) . '?gb=1';
    }

    /**
     * 新着情報
     *
     * @return string
     */
    public static function newInformation()
    {
        self::push(PageId::NEW_INFORMATION);

        return self::route('トップ');
    }

    /**
     * @param Orm\Site $site
     * @return string
     */
    public static function site(Orm\Site $site)
    {
        $before = self::beforeHas([
            PageId::NEW_INFORMATION,
            PageId::GAME_DETAIL,
            PageId::USER_TIMELINE,
            PageId::USER_SITE,
            PageId::USER_FAVORITE_SITE,
            PageId::USER_GOOD_SITE,
            PageId::FRIEND_TIMELINE,
            PageId::FRIEND_SITE,
            PageId::FRIEND_FAVORITE_SITE,
            PageId::SITE_BY_SOFT,
            PageId::SITE_SEARCH,
            PageId::SITE_ADD_CONFIRM,
            PageId::SITE_UPDATE_HISTORY_ADD,
            PageId::SITE_UPDATE_HISTORY_EDIT,
            PageId::SITE_FOOT_PRINT,
            PageId::SITE_ACCESS_LOG
        ]);

        self::push(PageId::SITE, $site->id);

        $backToSiteManage = [
            PageId::SITE_ADD_CONFIRM,
            PageId::SITE_UPDATE_HISTORY_ADD,
            PageId::SITE_UPDATE_HISTORY_EDIT,
            PageId::SITE_FOOT_PRINT,
            PageId::SITE_ACCESS_LOG
        ];

        if ($site->approval_status != ApprovalStatus::OK) {
            return self::route('プロフィール2', ['showId' => Auth::user()->show_id, 'show' => 'site']);
        } else if ($before === false) {
            return self::route('サイトトップ');
        } else if ($before[0] == PageId::GAME_DETAIL) {
            return self::route('ソフト別サイト一覧', ['soft' => $before[2]]);
        } else if (in_array($before[0], $backToSiteManage)) {
            return self::route('サイト管理');
        } else {
            return $before[1];
        }
    }

    /**
     * ソフト詳細
     *
     * @param Orm\GameSoft $soft
     * @return string
     */
    public static function softDetail(Orm\GameSoft $soft)
    {
        $before = self::beforeHas([
            PageId::SITE,
            PageId::NEW_INFORMATION,
            PageId::REVIEW,
            PageId::USER_TIMELINE,
            PageId::USER_FAVORITE_GAME,
            PageId::FRIEND_TIMELINE,
            PageId::FRIEND_FAVORITE_GAME,
            PageId::GAME_SERIES_DETAIL,
            PageId::GAME_COMPANY_DETAIL,
            PageId::GAME_PLATFORM_DETAIL,
            PageId::SITE_BY_SOFT
        ]);

        self::push(PageId::GAME_DETAIL, $soft->id);

        if ($before === false || $before[0] == PageId::SITE_BY_SOFT) {
            return self::route('ゲーム一覧');
        } else {
            return $before[1];
        }
    }

    /**
     * クリアして指定ルートへ
     *
     * @param $name
     * @param array $parameters
     * @return string
     */
    public static function clearAndRoute($name, $parameters = [])
    {
        self::clear();
        return route($name, $parameters);
    }

    /**
     * ゲーム会社詳細
     *
     * @param Orm\GameCompany $company
     * @return string
     */
    public static function companyDetail(Orm\GameCompany $company)
    {
        $before = self::beforeHas([PageId::GAME_DETAIL]);

        self::push(PageId::GAME_COMPANY_DETAIL, $company->id);

        if ($before === false) {
            return self::route('ゲーム会社一覧');
        } else {
            return $before[1];
        }
    }

    /**
     * プラットフォーム詳細
     *
     * @param Orm\GamePlatform $platform
     * @return string
     */
    public static function platformDetail(Orm\GamePlatform $platform)
    {
        $before = self::beforeHas([PageId::GAME_DETAIL]);

        self::push(PageId::GAME_PLATFORM_DETAIL, $platform->id);

        if ($before === false) {
            return self::route('プラットフォーム一覧');
        } else {
            return $before[1];
        }
    }

    /**
     * シリーズ詳細
     *
     * @param Orm\GameSeries $series
     * @return string
     */
    public static function seriesDetail(Orm\GameSeries $series)
    {
        $before = self::beforeHas([PageId::GAME_DETAIL]);

        self::push(PageId::GAME_SERIES_DETAIL, $series->id);

        if ($before === false) {
            return self::route('シリーズ一覧');
        } else {
            return $before[1];
        }
    }

    /**
     * ゲーム別サイト一覧
     *
     * @param Orm\GameSoft $soft
     * @return string
     */
    public static function siteBySoft(Orm\GameSoft $soft)
    {
        $before = self::beforeHas([PageId::SITE]);

        self::push(PageId::SITE_BY_SOFT, $soft->id);

        if ($before === false) {
            return self::route('ゲーム詳細', ['soft' => $soft->id]);
        } else {
            return $before[1];
        }
    }

    /**
     * お気に入り登録ユーザー一覧
     *
     * @param Orm\GameSoft $soft
     * @return string
     */
    public static function gameFavoriteUserList(Orm\GameSoft $soft)
    {
        self::push(PageId::GAME_FAVORITE_USER_LIST, $soft->id);
        return self::route('ゲーム詳細', ['soft' => $soft->id]);
    }

    /**
     * ユーザー情報系(同じ処理なのでまとめて)
     *
     * @param $pageId
     * @return string
     */
    public static function userGroup($pageId)
    {
        $before = self::before();
        self::push($pageId);

        if ($before === false) {
            return self::route('トップ');
        } else {
            return $before[1];
        }
    }

    /**
     * レビュー
     *
     * @param Orm\Review $review
     * @return string
     */
    public static function review(Orm\Review $review)
    {
        $before = self::beforeHas([
            PageId::NEW_INFORMATION,
            PageId::REVIEW_BY_SOFT,
            PageId::USER_TIMELINE,
            PageId::USER_REVIEW,
            PageId::FRIEND_TIMELINE,
            PageId::FRIEND_REVIEW
        ]);

        self::push(PageId::REVIEW, $review->id);

        if ($before === false) {
            return self::route('レビュートップ');
        } else {
            return $before[1];
        }
    }

    /**
     * 新着レビューリスト
     *
     * @return string
     */
    public static function reviewNewList()
    {
        self::push(PageId::REVIEW_NEW_LIST);
        return self::route('レビュートップ');
    }

    /**
     * ゲーム別レビュー一覧
     *
     * @param Orm\GameSoft $soft
     * @return string
     */
    public static function reviewBySoft(Orm\GameSoft $soft)
    {
        $before = self::beforeHas([PageId::GAME_DETAIL]);

        self::push(PageId::REVIEW_BY_SOFT, $soft->id);

        if ($before === false) {
            return self::route('レビュートップ');
        } else {
            return $before[1];
        }
    }

    /**
     * レビュー入力
     *
     * @param Orm\GameSoft $soft
     * @return string
     */
    public static function reviewInput(Orm\GameSoft $soft)
    {
        $before = self::beforeHas([PageId::REVIEW_BY_SOFT, PageId::REVIEW_CONFIRM, PageId::USER_REVIEW_DRAFT, PageId::GAME_DETAIL]);

        self::push(PageId::REVIEW_INPUT, $soft->id);

        if ($before === false) {
            return self::route('レビュートップ');
        } else {
            return $before[1];
        }
    }

    /**
     * レビュー入力確認
     *
     * @param Orm\GameSoft $soft
     * @return string
     */
    public static function reviewConfirm(Orm\GameSoft $soft)
    {
        $before = self::beforeHas([PageId::USER_REVIEW_DRAFT]);

        self::push(PageId::REVIEW_CONFIRM, $soft->id);

        if ($before === false) {
            return self::route('レビュー入力', ['soft' => $soft->id]);
        } else {
            return $before[1];
        }
    }

    /**
     * レビューについて
     *
     * @return string
     */
    public static function reviewAbout()
    {
        $before = self::beforeHas([
            PageId::REVIEW_INPUT,
            PageId::REVIEW,
            PageId::REVIEW_BY_SOFT
        ]);

        self::push(PageId::REVIEW_ABOUT);

        if ($before === false) {
            return self::route('レビュートップ');
        } else {
            return $before[1];
        }
    }

    /**
     * サイト検索
     *
     * @return string
     */
    public static function siteSearch()
    {
        self::push(PageId::SITE_SEARCH);
        return self::route('サイトトップ');
    }

    /**
     * サイト更新履歴
     *
     * @param Orm\Site $site
     * @return string
     */
    public static function siteUpdateHistory(Orm\Site $site)
    {
        self::push(PageId::SITE_UPDATE_HISTORY);
        return self::route('サイト詳細', ['site' => $site->id]);
    }

    /**
     * サイトアクセスログ
     *
     * @param Orm\Site $site
     * @return string
     */
    public static function siteAccessLog(Orm\Site $site)
    {
        self::push(PageId::SITE_ACCESS_LOG);
        return self::route('サイト詳細', ['site' => $site->id]);
    }

    /**
     * サイト登録
     *
     * @return string
     */
    public static function siteAdd()
    {
        self::push(PageId::SITE_ADD);
        return self::route('プロフィール2', ['showId' => Auth::user()->show_id, 'show' => 'site']);
    }

    /**
     * サイトバナー
     *
     * @param Orm\Site $site
     * @return string
     */
    public static function siteBanner(Orm\Site $site)
    {
        $before = self::beforeHas([PageId::SITE_ADD]);

        self::push(PageId::SITE_BANNER);

        if ($before === false) {
            return self::route('サイト詳細', ['site' => $site->id]);
        } else {
            return $before[1];
        }
    }

    /**
     * サイトバナー(R-18)
     *
     * @param Orm\Site $site
     * @return string
     */
    public static function siteBannerR18(Orm\Site $site)
    {
        $before = self::beforeHas([PageId::SITE_BANNER]);

        self::push(PageId::SITE_BANNER_R18);

        if ($before === false) {
            return self::route('サイト詳細', ['site' => $site->id]);
        } else {
            return $before[1];
        }
    }

    /**
     * お気に入り登録できません
     *
     * @param Orm\GameSoft $soft
     * @return string
     */
    public static function maxFavoriteSoft(Orm\GameSoft $soft)
    {
        $before = self::beforeHas([PageId::GAME_DETAIL]);

        self::push(PageId::GAME_FAVORITE_MAX, $soft->id);

        if ($before === false) {
            return self::route('ゲーム詳細', ['soft' => $soft->id]);
        } else {
            return $before[1];
        }
    }

    /**
     * メッセージ入力
     *
     * @return string
     */
    public static function messageWrite()
    {
        $before = self::beforeHas([PageId::MESSAGE_SHOW, PageId::USER_MESSAGE, PageId::USER_MESSAGE_SENT]);

        self::push(PageId::MESSAGE_WRITE);

        if ($before === false) {
            return self::route('プロフィール2', ['showId' => Auth::user()->show_id, 'show' => 'message']);
        } else {
            return $before[1];
        }
    }

    /**
     * メッセージ表示
     *
     * @return string
     */
    public static function messageShow()
    {
        $before = self::beforeHas([PageId::USER_MESSAGE, PageId::USER_MESSAGE_SENT]);

        self::push(PageId::MESSAGE_SHOW);

        if ($before === false) {
            return self::route('プロフィール2', ['showId' => Auth::user()->show_id, 'show' => 'message']);
        } else {
            return $before[1];
        }
    }
}