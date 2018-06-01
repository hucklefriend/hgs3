<?php
/**
 * ユーザー行動タイムライン
 */

namespace Hgs3\Constants;

class UserActionTimelineType
{
    const SIGN_UP = 0;
    const FOLLOW = 10;
    const REMOVE_FOLLOW = 11;

    const ADD_SITE = 20;
    const UPDATE_SITE = 21;
    const DELETE_SITE = 22;
    const SITE_GOOD = 23;
    const ADD_SITE_UPDATE_HISTORY = 24;

    const ADD_REVIEW = 30;
    const DELETE_REVIEW = 31;
    const REVIEW_FMFM = 32;
    const REVIEW_N = 33;

    const CHANGE_ICON = 40;
    const CHANGE_PROFILE = 41;


    public static $textFormat = [
        self::SIGN_UP => 'ホラーゲームネットワークに参加しました！',
        self::FOLLOW => '<a href="%s">%sさん</a>をフォローしました。',
        self::REMOVE_FOLLOW => '<a href="%s">%sさん</a>のフォローを解除しました。',
        self::ADD_SITE => 'サイト「<a href="%s">%s</a>」を登録しました。',
        self::UPDATE_SITE => 'サイト「<a href="%s">%s</a>」を更新しました。',
        self::DELETE_SITE => 'サイト「<a href="%s">%s</a>」を削除しました。',
        self::SITE_GOOD => 'サイト「<a href="%s">%s</a>」をいいねしました。',
        self::ADD_SITE_UPDATE_HISTORY => 'サイト「<a href="%s">%s</a>」の更新履歴を登録しました。',

        self::ADD_REVIEW => '<a href="%s">%sのレビュー</a>を投稿しました。',
        self::DELETE_REVIEW => '%sのレビューを削除しました。',
        self::REVIEW_FMFM => '%sさんの%sのレビューをふむふむしました。',
        self::REVIEW_N => '%sさんの%sのレビューをふむふむしました。',

        self::CHANGE_ICON => '',
        self::CHANGE_PROFILE => ''
    ];

}
