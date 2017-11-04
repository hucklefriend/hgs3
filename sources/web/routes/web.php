<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// 管理者のみ
Route::group(['middleware' => ['auth', 'can:admin']], function () {
    // 不正レビュー
    Route::get('/admin/injustice_review', 'Admin\InjusticeReviewController@index');

    Route::get('/timeline', 'TimelineController@index');
    Route::get('/timeline/add', 'TimelineController@input');
    Route::post('/timeline/add', 'TimelineController@add');
    Route::delete('/timeline/', 'TimelineController@remove');
});

// エディターのみ
Route::group(['middleware' => ['auth', 'can:editor']], function () {
    // ゲーム追加
    Route::get('/game/soft/add', 'Game\SoftController@add');
    Route::post('/game/soft/add', 'Game\SoftController@insert');

    // ゲーム編集
    Route::get('/game/soft/edit/{soft}', 'Game\SoftController@edit');
    Route::patch('/game/soft/edit/{soft}', 'Game\SoftController@update');

    // パッケージ登録
    Route::get('/game/soft/package/add/{soft}', 'Game\PackageController@add');
    Route::post('/game/soft/package/add/{soft}', 'Game\PackageController@store');

    // ゲーム会社
    Route::get('/game/company/add', 'Game\CompanyController@add');
    Route::post('/game/company/add', 'Game\CompanyController@insert');
    Route::get('/game/company/edit/{company}', 'Game\CompanyController@edit');
    Route::patch('/game/company/edit/{company}', 'Game\CompanyController@update');

    // プラットフォーム
    Route::get('/game/platform/add', 'Game\PlatformController@add');
    Route::post('/game/platform/add', 'Game\PlatformController@insert');
    Route::get('/game/platform/edit/{platform}', 'Game\PlatformController@edit');
    Route::patch('/game/platform/edit/{platform}', 'Game\PlatformController@update');

    // シリーズ
    Route::get('/game/series/add', 'Game\SeriesController@add');
    Route::post('/game/series/add', 'Game\SeriesController@insert');
    Route::get('/game/series/edit/{series}', 'Game\SeriesController@edit');
    Route::patch('/game/series/edit/{series}', 'Game\SeriesController@update');
});

Route::get('/', 'TopController@index');
Route::get('/auth/login', 'Account\LoginController@login')->name('login');
Route::post('/auth/login', 'Account\LoginController@authenticate');
Route::get('/auth/logout', 'Account\LoginController@logout');

// アカウント作成
Route::post('/account/signup/pr', 'Account\SignUpController@sendPRMail');
Route::get('/account/register/{token}', 'Account\SignUpController@register');
Route::post('/account/register', 'Account\SignUpController@registration');
Route::get('/account/signup', 'Account\SignUpController@index');

// ゲーム
Route::get('/game', 'Game\SoftController@index');
Route::get('/game/soft/{soft}', 'Game\SoftController@detail');

// レビュー
Route::get('/review', 'Review\ReviewController@index')->name('review');
Route::get('/review/package_select/{soft}', 'Review\ReviewController@packageSelect')->middleware('auth');
Route::get('/review/write/{soft}/{package}', 'Review\ReviewController@input')->middleware('auth');
Route::post('/review/confirm/{soft}/{package}', 'Review\ReviewController@confirm')->middleware('auth');
Route::post('/review/save/{soft}/{package}', 'Review\ReviewController@save')->middleware('auth');
Route::delete('/review/draft/{softId}/{packageId}', 'Review\ReviewController@deleteDraft')->middleware('auth');
Route::get('/review/soft/{soft}', 'Review\ReviewController@soft');
Route::post('/review/good/{review}', 'Review\GoodController@good')->middleware('auth');
Route::delete('/review/good/{review}', 'Review\GoodController@cancel')->middleware('auth');
Route::get('/review/detail/{review}', 'Review\ReviewController@detail');
Route::get('/review/good/history/{review}', 'Review\GoodController@history');
Route::get('/review/edit/{review}', 'Review\ReviewController@edit');
Route::patch('/review/edit/{review}', 'Review\ReviewController@update');
Route::delete('/review/edit/{review}', 'Review\ReviewController@delete');
Route::get('/review/new_arrivals', 'Review\ReviewController@newArrivals');


// 不正レビュー
Route::get('/review/fraud_report/report/{review}', 'Review\FraudReportController@input');
Route::post('/review/fraud_report/report/{review}', 'Review\FraudReportController@report');
Route::get('/review/fraud_report/list/{review}', 'Review\FraudReportController@list');
/*
Route::post('/game/injustice_review/input/{review}', 'Game\InjusticeReviewController@report');
Route::get('/game/injustice_review/detail/{ir}', 'Game\InjusticeReviewController@detail');
Route::post('/game/injustice_review/comment/{ir}', 'Game\InjusticeReviewController@comment');
Route::get('/game/injustice_review/{review}', 'Game\InjusticeReviewController@list');
*/

// サイト
Route::get('/site', 'Site\SiteController@index');
Route::get('/site/search', 'Site\SiteController@search');
Route::get('/site/soft/{soft}', 'Site\SiteController@soft');
Route::get('/site/user/{user}', 'Site\SiteController@user');
Route::get('/site/detail/{site}', 'Site\SiteController@detail');
Route::get('/site/add', 'Site\SiteController@add')->middleware('auth');
Route::post('/site/add', 'Site\SiteController@insert')->middleware('auth');
Route::get('/site/edit/{site}', 'Site\SiteController@edit')->middleware('auth');
Route::patch('/site/edit/{site}', 'Site\SiteController@update')->middleware('auth');
Route::delete('/site/{site}', 'Site\SiteController@delete')->middleware('auth');
Route::get('/site/{site}', 'Site\SiteController@detail')->middleware('auth');
Route::post('/site/good/{site}', 'Site\GoodController@good')->middleware('auth');
Route::delete('/site/good/{site}', 'Site\GoodController@cancel')->middleware('auth');
Route::get('/site/good_history/{site}', 'Site\GoodController@history')->middleware('auth');
Route::get('/site/go/{site}', 'Site\SiteController@go');
Route::get('/site/footprint/{site}', 'Site\FootprintController@site')->middleware('auth');
Route::get('/site/favorite/{site}', 'Site\FavoriteSiteController@site')->middleware('auth');
Route::delete('/site/delete/{site}', 'Site\SiteController@delete')->middleware('auth');

// ゲーム会社
Route::get('/game/company', 'Game\CompanyController@index');
Route::get('/game/company/{company}', 'Game\CompanyController@detail');

// プラットフォーム
Route::get('/game/platform', 'Game\PlatformController@index');
Route::get('/game/platform/{platform}', 'Game\PlatformController@detail');

// シリーズ
Route::get('/game/series', 'Game\SeriesController@index');
Route::get('/game/series/{series}', 'Game\SeriesController@detail');

// マイページ
Route::get('/mypage', 'User\MyPageController@index')->middleware('auth');
Route::get('/user/profile/edit', 'User\ProfileController@edit')->middleware('auth');
Route::patch('/user/profile/edit', 'User\ProfileController@update')->middleware('auth');
Route::get('/user/profile/change_icon', 'User\ProfileController@selectIcon')->middleware('auth');
Route::patch('/user/profile/change_icon', 'User\ProfileController@changeIcon')->middleware('auth');
Route::delete('/user/profile/change_icon', 'User\ProfileController@deleteIcon')->middleware('auth');
Route::get('/user/profile/{user}', 'User\ProfileController@index')->middleware('auth');
Route::get('/user/profile/{user}/{type}', 'User\ProfileController@index')->middleware('auth');
Route::get('/user/profile/{user}/timeline/mypage/{time}', 'User\ProfileController@moreTimelineMyPage')->middleware('auth');
Route::get('/user/profile', 'User\ProfileController@myself')->middleware('auth');
Route::get('/user/communities/{user}', 'User\ProfileController@community')->middleware('auth');
Route::get('/mypage/favorite_soft', 'User\FavoriteSoftController@myself')->middleware('auth');
Route::get('/mypage/favorite_site', 'User\FavoriteSiteController@myself')->middleware('auth');
Route::get('/mypage/follow', 'User\MyPageController@follow')->middleware('auth');
Route::get('/mypage/follower', 'User\MyPageController@follower')->middleware('auth');
Route::get('/mypage/review', 'User\MyPageController@review')->middleware('auth');

// タイムライン
Route::get('/user/timeline', 'User\ProfileController@timeline')->middleware('auth');
Route::get('/user/user_action_timeline/{user}', 'User\ProfileController@userActionTimeline')->middleware('auth');

// お気に入りゲーム
Route::get('/game/favorite/{soft}', 'Game\FavoriteSoftController@index');
Route::post('/user/favorite_soft', 'User\FavoriteSoftController@add')->middleware('auth');
Route::delete('/user/favorite_soft', 'User\FavoriteSoftController@remove')->middleware('auth');
Route::get('/user/favorite_soft/{user}', 'User\ProfileController@favoriteSoft');

// 遊んだゲーム
Route::get('game/played_user/{soft}', 'Game\PlayedUserController@index');
Route::get('user/played_soft/{user}', 'User\PlayedSoftController@index');
Route::post('user/played_soft/{soft}', 'User\PlayedSoftController@add')->middleware('auth');
Route::put('user/played_soft/{upg}', 'User\PlayedSoftController@edit')->middleware('auth');
Route::delete('user/played_soft/{upg}', 'User\PlayedSoftController@remove')->middleware('auth');


// お気に入りサイト
Route::get('/site/favorite/{site}', 'Site\FavoriteSiteController@index');
Route::post('/user/favorite_site/{site}', 'User\FavoriteSiteController@add')->middleware('auth');
Route::delete('/user/favorite_site/{site}', 'User\FavoriteSiteController@remove')->middleware('auth');
Route::get('/user/favorite_site/{user}', 'User\ProfileController@favoriteSite')->middleware('auth');

// 自分のサイト
Route::get('/user/site/myself', 'User\SiteController@myself')->middleware('auth');


// フォロー
Route::get('/user/follow/{user}', 'User\ProfileController@follow')->middleware('auth');
Route::get('/user/follower/{user}', 'User\ProfileController@follower')->middleware('auth');
Route::post('/user/follow', 'User\FollowController@add')->middleware('auth');
Route::delete('/user/follow', 'User\FollowController@remove')->middleware('auth');

// コミュニティ
Route::get('/community', 'Community\CommunityController@index');

// ユーザーコミュニティ
Route::post('/community/u/{uc}/join', 'Community\UserCommunityController@join')->middleware('auth');
Route::post('/community/u/{uc}/leave', 'Community\UserCommunityController@leave')->middleware('auth');
Route::get('/community/u/{uc}/member', 'Community\UserCommunityController@members')->middleware('auth');
Route::get('/community/u/{uc}/topics', 'Community\UserCommunityController@topics')->middleware('auth');
Route::post('/community/u/{uc}/topics', 'Community\UserCommunityController@write')->middleware('auth');
Route::get('/community/u/{uc}/topic/{uct}', 'Community\UserCommunityController@topicDetail')->middleware('auth');
Route::post('/community/u/{uc}/topic/{uct}', 'Community\UserCommunityController@writeResponse')->middleware('auth');
Route::delete('/community/u/{uc}/topic/{uct}', 'Community\UserCommunityController@erase')->middleware('auth');
Route::delete('/community/u/{uc}/topic_response/{uctr}', 'Community\UserCommunityController@eraseResponse')->middleware('auth');
Route::get('/community/u/{uc}', 'Community\UserCommunityController@detail')->middleware('auth');

// ゲームコミュニティ
Route::post('/community/g/{soft}/join', 'Community\GameCommunityController@join')->middleware('auth');
Route::post('/community/g/{soft}/leave', 'Community\GameCommunityController@leave')->middleware('auth');
Route::get('/community/g/{soft}/member', 'Community\GameCommunityController@members')->middleware('auth');
Route::get('/community/g/{soft}/topics', 'Community\GameCommunityController@topics')->middleware('auth');
Route::post('/community/g/{soft}/topics', 'Community\GameCommunityController@write')->middleware('auth');
Route::get('/community/g/{soft}/topic/{gct}', 'Community\GameCommunityController@topicDetail')->middleware('auth');
Route::post('/community/g/{soft}/topic/{gct}', 'Community\GameCommunityController@writeResponse')->middleware('auth');
Route::delete('/community/g/{soft}/topic/{gct}', 'Community\GameCommunityController@erase')->middleware('auth');
Route::delete('/community/g/{soft}/topic_response/{gctr}', 'Community\GameCommunityController@eraseResponse')->middleware('auth');
Route::get('/community/g/{soft}', 'Community\GameCommunityController@detail')->middleware('auth');
Route::get('/community/g', 'Community\GameCommunityController@index');

// 日記
Route::get('/diary', 'Diary\DiaryController@index');

// SNS
Route::get('/social/twitter/callback', 'Social\TwitterController@callback');
Route::get('/social/twitter/{mode}', 'Social\TwitterController@redirect');
Route::get('/social/facebook/callback', 'Social\FacebookController@callback');
Route::get('/social/facebook/{mode}', 'Social\FacebookController@redirect');
Route::get('/social/github/callback', 'Social\GitHubController@callback');
Route::get('/social/github/{mode}', 'Social\GitHubController@redirect');
Route::get('/social/google/callback', 'Social\GoogleController@callback');
Route::get('/social/google/{mode}', 'Social\GoogleController@redirect');

// サイトマップ
Route::get('/sitemap', 'TopController@sitemap');

// デバッグ用
Route::get('/test', 'TopController@test');