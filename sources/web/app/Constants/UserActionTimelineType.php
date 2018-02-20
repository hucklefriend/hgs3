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

    const ADD_REVIEW = 30;
    const UPDATE_REVIEW = 31;
    const DELETE_REVIEW = 32;
    const REVIEW_GOOD = 33;

    const CHANGE_ICON = 40;
    const CHANGE_PROFILE = 41;
}
