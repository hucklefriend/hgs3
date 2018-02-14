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
    // 管理メニュー
    Route::get('/admin', 'AdminController@index')->name('管理メニュー');

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

    // タイムライン管理
    Route::get('/timeline', 'TimelineController@index')->name('タイムライン管理');
    Route::get('/timeline/add', 'TimelineController@input')->name('タイムライン登録');
    Route::post('/timeline/add', 'TimelineController@add')->name('タイムライン登録処理');
    Route::delete('/timeline/', 'TimelineController@remove')->name('タイムライン削除処理');


    // 管理者によるサイト管理
    Route::get('/admin/site/approval', 'Site\ApprovalController@index')->name('承認待ちサイト一覧');
    Route::get('/admin/site/approval/judge/{site}', 'Site\ApprovalController@judge')->name('サイト判定');
    Route::patch('/admin/site/approval/judge/{site}/approve', 'Site\ApprovalController@approve')->name('サイト承認');
    Route::patch('/admin/site/approval/judge/{site}/reject', 'Site\ApprovalController@reject')->name('サイト拒否');

    // デバッグ用
    Route::get('/test', 'TopController@test');
});

// エディターのみ
Route::group(['middleware' => ['auth', 'can:editor']], function () {
    // マスター
    Route::get('/master', 'Master\TopController@index')->name('マスターメニュー');

    // ゲーム会社
    Route::get('/master/game_company', 'Master\GameCompanyController@index')->name('ゲーム会社マスター');
    Route::get('/master/game_company/edit/{gameCompany}', 'Master\GameCompanyController@edit')->name('ゲーム会社編集');
    Route::patch('/master/game_company/edit/{gameCompany}', 'Master\GameCompanyController@update')->name('ゲーム会社編集処理');

    // ゲーム登録・編集
    Route::get('/game/soft/add', 'Game\SoftController@add')->name('ゲームソフト登録');
    Route::post('/game/soft/add', 'Game\SoftController@insert')->name('ゲームソフト登録処理');
    Route::get('/game/soft/edit/{soft}', 'Game\SoftController@edit')->name('ゲームソフト編集');
    Route::patch('/game/soft/edit/{soft}', 'Game\SoftController@update')->name('ゲームソフト編集処理');

    // パッケージ登録・編集
    Route::get('/game/soft/package/add/{soft}', 'Game\PackageController@add')->name('パッケージ登録');
    Route::post('/game/soft/package/add/{soft}', 'Game\PackageController@insert')->name('パッケージ登録処理');
    Route::get('/game/soft/package/edit/{soft}/{package}', 'Game\PackageController@edit')->name('パッケージ編集');
    Route::patch('/game/soft/package/edit/{soft}/{package}', 'Game\PackageController@update')->name('パッケージ編集処理');
    Route::delete('/game/soft/package/{package}', 'Game\PackageController@delete')->name('パッケージ削除処理');

    // ゲーム会社登録・編集
    Route::get('/game/company/add', 'Game\CompanyController@add')->name('ゲーム会社登録');
    Route::post('/game/company/add', 'Game\CompanyController@insert')->name('ゲーム会社登録処理');
    Route::get('/game/company/edit/{company}', 'Game\CompanyController@edit')->name('ゲーム会社編集');
    Route::patch('/game/company/edit/{company}', 'Game\CompanyController@update')->name('ゲーム会社編集処理');

    // プラットフォーム
    Route::get('/game/platform/add', 'Game\PlatformController@add')->name('プラットフォーム登録');
    Route::post('/game/platform/add', 'Game\PlatformController@insert')->name('プラットフォーム登録処理');
    Route::get('/game/platform/edit/{platform}', 'Game\PlatformController@edit')->name('プラットフォーム編集');
    Route::patch('/game/platform/edit/{platform}', 'Game\PlatformController@update')->name('プラットフォーム編集処理');

    // シリーズ
    Route::get('/game/series/add', 'Game\SeriesController@add')->name('シリーズ登録');
    Route::post('/game/series/add', 'Game\SeriesController@insert')->name('シリーズ登録処理');
    Route::get('/game/series/edit/{series}', 'Game\SeriesController@edit')->name('シリーズ編集');
    Route::patch('/game/series/edit/{series}', 'Game\SeriesController@update')->name('シリーズ編集処理');
});


// ユーザーのみ
Route::group(['middleware' => ['auth']], function () {
    // レビュー
    Route::get('/review/package_select/{soft}', 'Review\ReviewController@packageSelect')->name('レビューパッケージ選択');
    Route::get('/review/write/{soft}/{package}', 'Review\ReviewController@input')->name('レビュー投稿');
    Route::post('/review/confirm/{soft}/{package}', 'Review\ReviewController@confirm')->name('レビュー投稿確認');
    Route::post('/review/save/{soft}/{package}', 'Review\ReviewController@save')->name('レビュー投稿処理');
    Route::delete('/review/draft/{softId}/{packageId}', 'Review\ReviewController@deleteDraft')->name('レビュー下書き削除');
    Route::post('/review/good/{review}', 'Review\GoodController@good')->name('レビューいいね');
    Route::delete('/review/good/{review}', 'Review\GoodController@cancel')->name('レビューいいね取消');
    Route::get('/review/edit/{review}', 'Review\ReviewController@edit')->name('レビュー編集');
    Route::patch('/review/edit/{review}', 'Review\ReviewController@update')->name('レビュー編集処理');
    Route::delete('/review/edit/{review}', 'Review\ReviewController@delete')->name('レビュー削除');

    // サイト管理
    Route::get('/user/site_manage', 'User\SiteManageController@index')->name('サイト管理');
    Route::get('/user/site_manage/add', 'User\SiteManageController@add')->name('サイト登録');
    Route::post('/user/site_manage/add', 'User\SiteManageController@insert')->name('サイト登録処理');
    Route::get('/user/site_manage/edit/{site}', 'User\SiteManageController@edit')->name('サイト編集');
    Route::patch('/user/site_manage/edit/{site}', 'User\SiteManageController@update')->name('サイト編集処理');
    Route::get('/user/site_manage/takeover', 'User\SiteManageController@takeOverSelect')->name('サイト引継選択');
    Route::get('/user/site_manage/takeover/{hgs2SiteId}', 'User\SiteManageController@takeOver')->name('サイト引継登録');
    Route::delete('/user/site_manage/{site}', 'User\SiteManageController@delete')->name('サイト削除');
    Route::get('/user/site_manage/update_history/add/{site}', 'User\SiteManageController@addUpdateHistory')->name('サイト更新履歴登録');
    Route::post('/user/site_manage/update_history/add/{site}', 'User\SiteManageController@insertUpdateHistory')->name('サイト更新履歴登録処理');
    Route::get('/user/site_manage/update_history/edit/{siteHistory}', 'User\SiteManageController@editUpdateHistory')->name('サイト更新履歴編集');
    Route::patch('/user/site_manage/update_history/edit/{siteHistory}', 'User\SiteManageController@updateUpdateHistory')->name('サイト更新履歴編集処理');
    Route::delete('/user/site_manage/update_history/delete/{siteHistory}', 'User\SiteManageController@deleteUpdateHistory')->name('サイト更新履歴削除処理');

    Route::get('/user/site/access/{site}', 'User\SiteAccessController@index')->name('サイトアクセスログ');
    Route::get('/user/site/access/{site}/daily-footprint/{date}', 'User\SiteAccessController@dailyFootprint')->name('サイト日別足跡');
    Route::get('/user/site/access/{site}/footprint', 'User\SiteAccessController@footprint')->name('サイト足跡');

    // サイト
    Route::post('/site/good/{site}', 'Site\GoodController@good')->name('サイトいいね');
    Route::delete('/site/good/{site}', 'Site\GoodController@cancel')->name('サイトいいねキャンセル');
    Route::get('/site/good_history/{site}', 'Site\GoodController@history');
    Route::get('/site/favorite/{site}', 'Site\FavoriteSiteController@site');
    Route::get('/site/update_history/{site}', 'Site\SiteController@updateHistory')->name('サイト更新履歴');
    
    // マイページ
    Route::get('/mypage', 'User\MyPageController@index')->name('マイページ');
    Route::get('/user/profile/edit', 'User\ProfileController@edit')->name('プロフィール編集');
    Route::patch('/user/profile/edit', 'User\ProfileController@update')->name('プロフィール編集実行');
    Route::get('/user/profile/change_icon', 'User\ProfileController@changeIcon')->name('アイコン変更');
    Route::get('/user/profile/change_icon_round', 'User\ProfileController@changeIconRound')->name('アイコン丸み変更');
    Route::patch('/user/profile/change_icon_round', 'User\ProfileController@updateIconRound')->name('アイコン丸み変更処理');
    Route::get('/user/profile/change_icon_image', 'User\ProfileController@changeIconImage')->name('アイコン画像変更');
    Route::patch('/user/profile/change_icon_image', 'User\ProfileController@updateIconImage')->name('アイコン画像変更処理');
    Route::delete('/user/profile/change_icon', 'User\ProfileController@deleteIcon')->name('アイコン削除');
    Route::get('/mypage/favorite_soft', 'User\FavoriteSoftController@myself');
    Route::get('/mypage/favorite_site', 'User\FavoriteSiteController@myself');
    Route::get('/mypage/follow', 'User\MyPageController@follow');
    Route::get('/mypage/follower', 'User\MyPageController@follower');
    Route::get('/mypage/review', 'User\MyPageController@review');
    Route::get('/user/config', 'User\ProfileController@config')->name('コンフィグ');
    Route::patch('/user/config', 'User\ProfileController@updateConfig')->name('コンフィグ更新');

    // プロフィール
    Route::get('/user/profile/{showId}', 'User\ProfileController@index')->name('プロフィール');
    Route::get('/user/profile/{showId}/{show}', 'User\ProfileController@index')->name('プロフィール2');
    Route::get('/user/profile/{showId}/timeline/mypage', 'User\ProfileController@moreTimelineMyPage')->name('タイムライン追加取得');
    Route::get('/user/communities/{showId}', 'User\ProfileController@community')->name('ユーザーのコミュニティ');
    Route::get('/user/timeline', 'User\ProfileController@timeline')->name('ユーザーのタイムライン');
    Route::get('/user/user_action_timeline/{showId}', 'User\ProfileController@userActionTimeline')->name('ユーザーの行動タイムライン');
    Route::get('/user/favorite_site/{showId}', 'User\FavoriteSiteController@index')->name('ユーザーのお気に入りサイト');
    Route::get('/user/follow/{showId}', 'User\FollowController@index')->name('ユーザーのフォロー');
    Route::get('/user/follower/{showId}', 'User\FollowController@follower')->name('ユーザーのフォロワー');
    Route::get('/user/review/{showId}', 'User\ReviewController@index')->name('ユーザーのレビュー');
    Route::get('/user/diary/{showId}', 'User\Diary@index')->name('ユーザーの日記');
    Route::get('/user/site/{showId}', 'User\SiteManageController@index')->name('ユーザーのサイト');
    Route::get('/user/favorite_soft/{showId}', 'User\FavoriteSoftController@index')->name('ユーザーのお気に入りゲーム');

    Route::post('/user/favorite_soft', 'User\FavoriteSoftController@add')->name('お気に入りゲーム登録処理');
    Route::delete('/user/favorite_soft', 'User\FavoriteSoftController@remove')->name('お気に入りゲーム削除処理');

    Route::post('/user/played_soft/{soft}', 'User\PlayedSoftController@add');
    Route::put('/user/played_soft/{upg}', 'User\PlayedSoftController@edit');
    Route::delete('user/played_soft/{upg}', 'User\PlayedSoftController@remove');
    Route::post('/user/favorite_site/{site}', 'User\FavoriteSiteController@add')->name('お気に入りサイト登録処理');
    Route::delete('/user/favorite_site/{site}', 'User\FavoriteSiteController@remove')->name('お気に入りサイト削除処理');
    Route::post('/user/follow', 'User\FollowController@add')->name('フォロー登録');
    Route::delete('/user/follow', 'User\FollowController@remove')->name('フォロー解除');

    // ユーザーコミュニティ
    Route::post('/community/u/{uc}/join', 'Community\UserCommunityController@join')->name('ユーザーコミュニティ参加処理');
    Route::post('/community/u/{uc}/leave', 'Community\UserCommunityController@leave')->name('ユーザーコミュニティ脱退処理');
    Route::get('/community/u/{uc}/member', 'Community\UserCommunityController@members')->name('ユーザーコミュニティメンバー');
    Route::get('/community/u/{uc}/topics', 'Community\UserCommunityController@topics')->name('ユーザーコミュニティ投稿一覧');
    Route::post('/community/u/{uc}/topics', 'Community\UserCommunityController@write')->name('ユーザーコミュニティ投稿処理');
    Route::get('/community/u/{uc}/topic/{uct}', 'Community\UserCommunityController@topicDetail')->name('ユーザーコミュニティ投稿詳細');
    Route::post('/community/u/{uc}/topic/{uct}', 'Community\UserCommunityController@writeResponse')->name('ユーザーコミュニティレス投稿処理');
    Route::delete('/community/u/{uc}/topic/{uct}', 'Community\UserCommunityController@erase')->name('ユーザーコミュニティ投稿削除処理');
    Route::delete('/community/u/{uc}/topic_response/{uctr}', 'Community\UserCommunityController@eraseResponse')->name('ユーザーコミュニティレス削除処理');
    Route::get('/community/u/{uc}', 'Community\UserCommunityController@detail')->name('ユーザーコミュニティ');

    // ゲームコミュニティ
    Route::post('/community/g/{soft}/join', 'Community\GameCommunityController@join')->name('ゲームコミュニティ参加処理');;
    Route::post('/community/g/{soft}/leave', 'Community\GameCommunityController@leave')->name('ゲームコミュニティ脱退処理');
    Route::get('/community/g/{soft}/member', 'Community\GameCommunityController@members')->name('ゲームコミュニティメンバー');
    Route::get('/community/g/{soft}/topics', 'Community\GameCommunityController@topics')->name('ゲームコミュニティ投稿一覧');
    Route::post('/community/g/{soft}/topics', 'Community\GameCommunityController@write')->name('ゲームコミュニティ投稿処理');
    Route::get('/community/g/{soft}/topic/{topic}', 'Community\GameCommunityController@topicDetail')->name('ゲームコミュニティ投稿詳細');
    Route::post('/community/g/{soft}/topic/{topic}', 'Community\GameCommunityController@writeResponse')->name('ゲームコミュニティレス投稿処理');
    Route::delete('/community/g/{soft}/topic/{topic}', 'Community\GameCommunityController@erase')->name('ゲームコミュニティ投稿削除処理');
    Route::delete('/community/g/{soft}/topic_response/{topicResponse}', 'Community\GameCommunityController@eraseResponse')->name('ゲームコミュニティレス削除処理');
    Route::get('/community/g/{soft}', 'Community\GameCommunityController@detail')->name('ゲームコミュニティ');
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
Route::get('/game/soft/package/{packageId}', 'Game\SoftController@detailByPackage')->name('パッケージからゲーム詳細');
Route::get('/game/soft/{soft}', 'Game\SoftController@detail')->name('ゲーム詳細');

// レビュー
Route::get('/review', 'Review\ReviewController@index')->name('レビュートップ');
Route::get('/review/soft/{soft}', 'Review\ReviewController@soft')->name('ソフト別レビュー一覧');
Route::get('/review/detail/{review}', 'Review\ReviewController@detail')->name('レビュー');
Route::get('/review/good/history/{review}', 'Review\GoodController@history')->name('レビューいいね履歴');
Route::get('/review/new_arrivals', 'Review\ReviewController@newArrivals')->name('新着レビュー一覧');

// 不正レビュー
Route::get('/review/fraud_report/report/{review}', 'Review\FraudReportController@input');
Route::post('/review/fraud_report/report/{review}', 'Review\FraudReportController@report');
Route::get('/review/fraud_report/list/{review}', 'Review\FraudReportController@list');

// サイト
Route::get('/site', 'Site\SiteController@index')->name('サイトトップ');
Route::get('/site/timeline', 'Site\SiteController@timeline')->name('サイトタイムライン');
Route::get('/site/new_arrival', 'Site\SiteController@newArrival')->name('新着サイト一覧');
Route::get('/site/update', 'Site\SiteController@newUpdate')->name('更新サイト一覧');
Route::get('/site/soft/{soft}', 'Site\SiteController@soft')->name('ソフト別サイト一覧');
Route::get('/site/user/{showId}', 'Site\SiteController@user')->name('ユーザーサイト一覧');
Route::get('/site/detail/{site}', 'Site\SiteController@detail')->name('サイト詳細');
Route::get('/site/go/{site}', 'Site\SiteController@go')->name('サイト遷移');

// ゲーム会社
Route::get('/game/company', 'Game\CompanyController@index')->name('ゲーム会社一覧');
Route::get('/game/company/{company}', 'Game\CompanyController@detail')->name('ゲーム会社詳細');

// プラットフォーム
Route::get('/game/platform', 'Game\PlatformController@index')->name('プラットフォーム一覧');
Route::get('/game/platform/{platform}', 'Game\PlatformController@detail')->name('プラットフォーム詳細');

// シリーズ
Route::get('/game/series', 'Game\SeriesController@index')->name('シリーズ一覧');
Route::get('/game/series/{series}', 'Game\SeriesController@detail')->name('シリーズ詳細');

// お気に入りゲーム
Route::get('/game/favorite/{soft}', 'Game\FavoriteSoftController@index')->name('お気に入りゲーム登録ユーザー一覧');

// 遊んだゲーム
Route::get('game/played_user/{soft}', 'Game\PlayedUserController@index');
Route::get('user/played_soft/{user}', 'User\PlayedSoftController@index');

// お気に入りサイト
Route::get('/site/favorite/{site}', 'Site\FavoriteSiteController@index');

// フォロー

// コミュニティ
Route::get('/community', 'Community\CommunityController@index')->name('コミュニティトップ');
Route::get('/community/g', 'Community\GameCommunityController@index')->name('ゲームコミュニティトップ');

// 日記
Route::get('/diary', 'Diary\DiaryController@index')->name('日記トップ');

// SNS
Route::get('/social/twitter/callback', 'Social\TwitterController@callback')->name('Twitterコールバック');
Route::get('/social/twitter/{mode}', 'Social\TwitterController@redirect')->name('Twitter');
Route::get('/social/facebook/callback', 'Social\FacebookController@callback')->name('facebookコールバック');
Route::get('/social/facebook/{mode}', 'Social\FacebookController@redirect')->name('facebook');
Route::get('/social/github/callback', 'Social\GitHubController@callback')->name('GitHubコールバック');
Route::get('/social/github/{mode}', 'Social\GitHubController@redirect')->name('GitHub');
Route::get('/social/google/callback', 'Social\GoogleController@callback')->name('Googleコールバック');
Route::get('/social/google/{mode}', 'Social\GoogleController@redirect')->name('Google');

// その他
Route::get('/sitemap', 'TopController@sitemap')->name('サイトマップ');
Route::get('/new_information', 'TopController@newInformation')->name('新着情報');
