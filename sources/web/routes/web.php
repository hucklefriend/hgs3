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
    // お知らせ
    Route::get('/system/notice/add', 'System\NoticeController@add')->name('お知らせ登録');
    Route::post('/system/notice/add', 'System\NoticeController@insert')->name('お知らせ登録処理');
    Route::get('/system/notice/edit/{notice}', 'System\NoticeController@edit')->name('お知らせ編集');
    Route::patch('/system/notice/edit/{notice}', 'System\NoticeController@update')->name('お知らせ編集処理');
    Route::delete('/system/notice/{notice}', 'System\NoticeController@delete')->name('お知らせ削除');

    // システム更新履歴
    Route::get('/system/update_history/add', 'System\UpdateHistoryController@add')->name('システム更新履歴登録');
    Route::post('/system/update_history/add', 'System\UpdateHistoryController@insert')->name('システム更新履歴登録処理');
    Route::get('/system/update_history/edit/{updateHistory}', 'System\UpdateHistoryController@edit')->name('システム更新履歴更新');
    Route::patch('/system/update_history/edit/{updateHistory}', 'System\UpdateHistoryController@update')->name('システム更新履歴更新処理');
    Route::delete('/system/update_history/{updateHistory}', 'System\UpdateHistoryController@delete')->name('システム更新履歴削除');

    // 不正レビュー
    Route::get('/admin/injustice_review', 'Admin\InjusticeReviewController@index');

    Route::get('/timeline', 'TimelineController@index');
    Route::get('/timeline/add', 'TimelineController@input');
    Route::post('/timeline/add', 'TimelineController@add');
    Route::delete('/timeline/', 'TimelineController@remove');

    // デバッグ用
    Route::get('/test', 'TopController@test');
});

// エディターのみ
Route::group(['middleware' => ['auth', 'can:editor']], function () {
    // マスター
    Route::get('/master', 'Master\TopController@index');

    // ゲーム会社
    Route::get('/master/game_company', 'Master\GameCompanyController@index');
    Route::get('/master/game_company/edit/{gameCompany}', 'Master\GameCompanyController@edit');
    Route::patch('/master/game_company/edit/{gameCompany}', 'Master\GameCompanyController@update');

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


// ユーザーのみ
Route::group(['middleware' => ['auth']], function () {
    // レビュー
    Route::get('/review/package_select/{soft}', 'Review\ReviewController@packageSelect');
    Route::get('/review/write/{soft}/{package}', 'Review\ReviewController@input');
    Route::post('/review/confirm/{soft}/{package}', 'Review\ReviewController@confirm');
    Route::post('/review/save/{soft}/{package}', 'Review\ReviewController@save');
    Route::delete('/review/draft/{softId}/{packageId}', 'Review\ReviewController@deleteDraft');
    Route::post('/review/good/{review}', 'Review\GoodController@good');
    Route::delete('/review/good/{review}', 'Review\GoodController@cancel');

    // サイト管理
    Route::get('/user/site_manage', 'User\SiteManageController@index')->name('サイト管理');
    Route::get('/user/site_manage/add', 'User\SiteManageController@add')->name('サイト登録');
    Route::post('/user/site_manage/add', 'User\SiteManageController@insert')->name('サイト登録処理');
    Route::get('/user/site_manage/edit/{site}', 'User\SiteManageController@edit')->name('サイト編集');
    Route::patch('/user/site_manage/edit/{site}', 'User\SiteManageController@update')->name('サイト編集処理');
    Route::get('/user/site_manage/takeover', 'User\SiteManageController@takeOverSelect')->name('サイト引継選択');
    Route::get('/user/site_manage/takeover/{hgs2SiteId}', 'User\SiteManageController@takeOver')->name('サイト引継登録');
    Route::delete('/user/site_manage/{site}', 'User\SiteManageController@delete')->name('サイト削除');

    // サイト
    Route::post('/site/good/{site}', 'Site\GoodController@good');
    Route::delete('/site/good/{site}', 'Site\GoodController@cancel');
    Route::get('/site/good_history/{site}', 'Site\GoodController@history');
    Route::get('/site/footprint/{site}', 'Site\FootprintController@site');
    Route::get('/site/favorite/{site}', 'Site\FavoriteSiteController@site');
    
    // マイページ
    Route::get('/mypage', 'User\MyPageController@index');
    Route::get('/user/profile/edit', 'User\ProfileController@edit');
    Route::patch('/user/profile/edit', 'User\ProfileController@update');
    Route::get('/user/profile/change_icon', 'User\ProfileController@selectIcon');
    Route::patch('/user/profile/change_icon', 'User\ProfileController@changeIcon');
    Route::delete('/user/profile/change_icon', 'User\ProfileController@deleteIcon');
    Route::get('/user/profile/{user}', 'User\ProfileController@index');
    Route::get('/user/profile/{user}/{type}', 'User\ProfileController@index');
    Route::get('/user/profile/{user}/timeline/mypage/{time}', 'User\ProfileController@moreTimelineMyPage');
    Route::get('/user/profile', 'User\ProfileController@myself');
    Route::get('/user/communities/{user}', 'User\ProfileController@community');
    Route::get('/mypage/favorite_soft', 'User\FavoriteSoftController@myself');
    Route::get('/mypage/favorite_site', 'User\FavoriteSiteController@myself');
    Route::get('/mypage/follow', 'User\MyPageController@follow');
    Route::get('/mypage/follower', 'User\MyPageController@follower');
    Route::get('/mypage/review', 'User\MyPageController@review');
    
    // タイムライン
    Route::get('/user/timeline', 'User\ProfileController@timeline');
    Route::get('/user/user_action_timeline/{user}', 'User\ProfileController@userActionTimeline');
    Route::post('/user/favorite_soft', 'User\FavoriteSoftController@add');
    Route::delete('/user/favorite_soft', 'User\FavoriteSoftController@remove');
    Route::post('user/played_soft/{soft}', 'User\PlayedSoftController@add');
    Route::put('user/played_soft/{upg}', 'User\PlayedSoftController@edit');
    Route::delete('user/played_soft/{upg}', 'User\PlayedSoftController@remove');
    Route::post('/user/favorite_site/{site}', 'User\FavoriteSiteController@add');
    Route::delete('/user/favorite_site/{site}', 'User\FavoriteSiteController@remove');
    Route::get('/user/favorite_site/{user}', 'User\ProfileController@favoriteSite');
    Route::get('/user/follow/{user}', 'User\ProfileController@follow');
    Route::get('/user/follower/{user}', 'User\ProfileController@follower');
    Route::post('/user/follow', 'User\FollowController@add');
    Route::delete('/user/follow', 'User\FollowController@remove');

    // ユーザーコミュニティ
    Route::post('/community/u/{uc}/join', 'Community\UserCommunityController@join');
    Route::post('/community/u/{uc}/leave', 'Community\UserCommunityController@leave');
    Route::get('/community/u/{uc}/member', 'Community\UserCommunityController@members');
    Route::get('/community/u/{uc}/topics', 'Community\UserCommunityController@topics');
    Route::post('/community/u/{uc}/topics', 'Community\UserCommunityController@write');
    Route::get('/community/u/{uc}/topic/{uct}', 'Community\UserCommunityController@topicDetail');
    Route::post('/community/u/{uc}/topic/{uct}', 'Community\UserCommunityController@writeResponse');
    Route::delete('/community/u/{uc}/topic/{uct}', 'Community\UserCommunityController@erase');
    Route::delete('/community/u/{uc}/topic_response/{uctr}', 'Community\UserCommunityController@eraseResponse');
    Route::get('/community/u/{uc}', 'Community\UserCommunityController@detail');

    // ゲームコミュニティ
    Route::post('/community/g/{soft}/join', 'Community\GameCommunityController@join');
    Route::post('/community/g/{soft}/leave', 'Community\GameCommunityController@leave');
    Route::get('/community/g/{soft}/member', 'Community\GameCommunityController@members');
    Route::get('/community/g/{soft}/topics', 'Community\GameCommunityController@topics');
    Route::post('/community/g/{soft}/topics', 'Community\GameCommunityController@write');
    Route::get('/community/g/{soft}/topic/{gct}', 'Community\GameCommunityController@topicDetail');
    Route::post('/community/g/{soft}/topic/{gct}', 'Community\GameCommunityController@writeResponse');
    Route::delete('/community/g/{soft}/topic/{gct}', 'Community\GameCommunityController@erase');
    Route::delete('/community/g/{soft}/topic_response/{gctr}', 'Community\GameCommunityController@eraseResponse');
    Route::get('/community/g/{soft}', 'Community\GameCommunityController@detail');
});

// トップ
Route::get('/', 'TopController@index')->name('トップ');

// 認証
Route::get('/auth/login', 'Account\LoginController@login')->name('ログイン');
Route::post('/auth/login', 'Account\LoginController@authenticate')->name('ログイン処理');
Route::get('/auth/logout', 'Account\LoginController@logout')->name('ログアウト');
Route::get('/auth/forget', 'Account\ForgotController@index')->name('パスワード再設定');
Route::post('/auth/send_forget', 'Account\ForgotController@sendPasswordResetMail')->name('パスワード再設定メール送信');
Route::get('/auth/password_reset', 'Account\ForgotController@input')->name('パスワード再設定入力');
Route::post('/auth/password_reset', 'Account\ForgotController@reset')->name('パスワード再設定処理');
Route::get('/auth/password_reset_complete', 'Account\ForgotController@complete')->name('パスワード再設定完了');

// お知らせ
Route::get('/notice', 'System\NoticeController@index')->name('お知らせ');
Route::get('/notice/{notice}', 'System\NoticeController@detail')->name('お知らせ内容');

// システム更新履歴
Route::get('/system_update', 'System\UpdateHistoryController@index')->name('システム更新履歴');
Route::get('/system_update/{updateHistory}', 'System\UpdateHistoryController@detail')->name('システム更新内容');

// アカウント作成
Route::get('/account/signup', 'Account\SignUpController@index')->name('ユーザー登録');
Route::post('/account/signup/pr', 'Account\SignUpController@sendPRMail')->name('仮登録メール送信');
Route::get('/account/register/{token}', 'Account\SignUpController@register')->name('本登録');
Route::post('/account/register', 'Account\SignUpController@registration')->name('本登録処理');

// ゲーム
Route::get('/game/soft', 'Game\SoftController@index')->name('ゲーム一覧');
Route::get('/game/soft/{soft}', 'Game\SoftController@detail')->name('ゲーム詳細');

// レビュー
Route::get('/review', 'Review\ReviewController@index')->name('レビュートップ');
Route::get('/review/soft/{soft}', 'Review\ReviewController@soft')->name('ソフト別レビュー一覧');
Route::get('/review/detail/{review}', 'Review\ReviewController@detail')->name('レビュー');
Route::get('/review/good/history/{review}', 'Review\GoodController@history')->name('レビューいいね履歴');
Route::get('/review/edit/{review}', 'Review\ReviewController@edit');
Route::patch('/review/edit/{review}', 'Review\ReviewController@update');
Route::delete('/review/edit/{review}', 'Review\ReviewController@delete');
Route::get('/review/new_arrivals', 'Review\ReviewController@newArrivals');


// 不正レビュー
Route::get('/review/fraud_report/report/{review}', 'Review\FraudReportController@input');
Route::post('/review/fraud_report/report/{review}', 'Review\FraudReportController@report');
Route::get('/review/fraud_report/list/{review}', 'Review\FraudReportController@list');

// サイト
Route::get('/site', 'Site\SiteController@index')->name('サイト');
Route::get('/site/search', 'Site\SiteController@search')->name('サイト検索');
Route::get('/site/soft/{soft}', 'Site\SiteController@soft')->name('ソフト別サイト');
Route::get('/site/user/{user}', 'Site\SiteController@user')->name('ユーザーサイト');
Route::get('/site/detail/{site}', 'Site\SiteController@detail')->name('サイト詳細');
Route::get('/site/go/{site}', 'Site\SiteController@go')->name('サイト遷移');

// ゲーム会社
Route::get('/game/company', 'Game\CompanyController@index');
Route::get('/game/company/{company}', 'Game\CompanyController@detail');

// プラットフォーム
Route::get('/game/platform', 'Game\PlatformController@index');
Route::get('/game/platform/{platform}', 'Game\PlatformController@detail');

// シリーズ
Route::get('/game/series', 'Game\SeriesController@index');
Route::get('/game/series/{gameSeries}', 'Game\SeriesController@detail');

// お気に入りゲーム
Route::get('/game/favorite/{soft}', 'Game\FavoriteSoftController@index');
Route::get('/user/favorite_soft/{user}', 'User\ProfileController@favoriteSoft');

// 遊んだゲーム
Route::get('game/played_user/{soft}', 'Game\PlayedUserController@index');
Route::get('user/played_soft/{user}', 'User\PlayedSoftController@index');


// お気に入りサイト
Route::get('/site/favorite/{site}', 'Site\FavoriteSiteController@index');

// フォロー

// コミュニティ
Route::get('/community', 'Community\CommunityController@index');
Route::get('/community/g', 'Community\GameCommunityController@index');

// 日記
Route::get('/diary', 'Diary\DiaryController@index');

// SNS
Route::get('/social/twitter/callback', 'Social\TwitterController@callback')->name('Twitterコールバック');
Route::get('/social/twitter/{mode}', 'Social\TwitterController@redirect')->name('Twitter');
Route::get('/social/facebook/callback', 'Social\FacebookController@callback')->name('facebookコールバック');
Route::get('/social/facebook/{mode}', 'Social\FacebookController@redirect')->name('facebook');
Route::get('/social/github/callback', 'Social\GitHubController@callback')->name('GitHubコールバック');
Route::get('/social/github/{mode}', 'Social\GitHubController@redirect')->name('GitHub');
Route::get('/social/google/callback', 'Social\GoogleController@callback')->name('Googleコールバック');
Route::get('/social/google/{mode}', 'Social\GoogleController@redirect')->name('Google');

// サイトマップ
Route::get('/sitemap', 'TopController@sitemap')->name('サイトマップ');

