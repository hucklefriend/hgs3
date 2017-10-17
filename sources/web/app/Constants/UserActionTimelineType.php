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


    const JOIN_GAME_COMMUNITY = 40;
    const LEAVE_GAME_COMMUNITY = 41;
    const WRITE_GAME_TOPIC = 42;


    const JOIN_USER_COMMUNITY = 50;
    const LEAVE_USER_COMMUNITY = 51;
    const WRITE_USER_TOPIC = 52;
    const CREATE_USER_COMMUNITY = 53;


    const CHANGE_ICON = 60;
    const CHANGE_PROFILE = 61;
}
