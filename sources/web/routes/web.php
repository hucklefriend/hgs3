<?php

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
    Route::get('/system/notice/future', 'System\NoticeController@future')->name('未来のお知らせ');
    Route::get('/system/notice/past', 'System\NoticeController@past')->name('過去のお知らせ');

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

    // 管理人によるレビューURL管理
    Route::get('/admin/review/url', 'Review\ApprovalController@index')->name('レビューURL判定');
    Route::patch('/admin/review/url/ok', 'Review\ApprovalController@ok')->name('レビューURL OK');
    Route::patch('/admin/review/url/ng', 'Review\ApprovalController@ng')->name('レビューURL NG');

    Route::get('/admin/hgs2site', 'AdminController@hgs2SiteChecker');

    // 管理人メッセージ
    Route::get('/admin/message/write/{user}/{resId}', 'User\MessageController@adminInput')->name('管理人メッセージ入力');
    Route::post('/admin/message/write/{user}', 'User\MessageController@adminWrite')->name('管理人メッセージ送信');

    // ユーザー管理
    //Route::get('/admin/user')->name('ユーザー管理');
});


// ユーザーのみ
Route::group(['middleware' => ['auth']], function () {
    // レビュー
    Route::post('/user/review/save', 'User\ReviewController@save')->name('レビュー保存');
    Route::get('/user/review/confirm/{soft}', 'User\ReviewController@confirm')->name('レビュー投稿確認');
    Route::get('/user/review/write/{soft}', 'User\ReviewController@input')->name('レビュー入力');
    Route::get('/user/review/{soft}/playing', 'User\ReviewController@inputPlaying')->name('レビュープレイ状況入力');
    Route::post('/user/review/{soft}/playing', 'User\ReviewController@savePlaying')->name('レビュープレイ状況保存');
    Route::get('/user/review/{soft}/fear', 'User\ReviewController@inputFear')->name('レビュー怖さ入力');
    Route::post('/user/review/{soft}/fear', 'User\ReviewController@saveFear')->name('レビュー怖さ保存');
    Route::get('/user/review/{soft}/good', 'User\ReviewController@inputGood')->name('レビュー良い点入力');
    Route::post('/user/review/{soft}/good', 'User\ReviewController@saveGood')->name('レビュー良い点保存');
    Route::get('/user/review/{soft}/bad', 'User\ReviewController@inputBad')->name('レビュー悪い点入力');
    Route::post('/user/review/{soft}/bad', 'User\ReviewController@saveBad')->name('レビュー悪い点保存');
    Route::get('/user/review/{soft}/general', 'User\ReviewController@inputGeneral')->name('レビュー総評入力');
    Route::post('/user/review/{soft}/general', 'User\ReviewController@saveGeneral')->name('レビュー総評保存');
    Route::patch('/user/review/{soft}/spoiler', 'User\ReviewController@saveSpoiler')->name('レビューネタバレありだった');
    Route::patch('/user/review/{soft}/not_spoiler', 'User\ReviewController@saveNotSpoiler')->name('レビューネタバレなしだった');
    Route::post('/user/review/write/{soft}', 'User\ReviewController@open')->name('レビュー公開');
    Route::delete('/user/review/{review}', 'User\ReviewController@delete')->name('レビュー削除');
    Route::put('/user/review/fmfm/{review}', 'Review\ImpressionController@fmfm')->name('ふむふむ');
    Route::put('/user/review/n/{review}', 'Review\ImpressionController@n')->name('んー…');
    Route::delete('/user/review/impression/{review}', 'Review\ImpressionController@delete')->name('レビュー印象取り消し');

    // サイト管理
    Route::get('/user/site_manage', 'User\SiteManageController@index')->name('サイト管理');
    Route::get('/user/site_manage/add', 'User\SiteManageController@add')->name('サイト登録');
    Route::post('/user/site_manage/add', 'User\SiteManageController@insert')->name('サイト登録処理');
    Route::get('/user/site_manage/banner/{site}/{isFirst}', 'User\SiteManageController@banner')->name('サイトバナー設定');
    Route::post('/user/site_manage/banner/{site}', 'User\SiteManageController@saveBanner')->name('サイトバナー設定処理');
    Route::get('/user/site_manage/r18banner/{site}/{isFirst}', 'User\SiteManageController@bannerR18')->name('R-18サイトバナー設定');
    Route::post('/user/site_manage/r18banner/{site}', 'User\SiteManageController@saveBannerR18')->name('R-18サイトバナー設定処理');
    Route::get('/user/site_manage/edit/{site}', 'User\SiteManageController@edit')->name('サイト編集');
    Route::patch('/user/site_manage/edit/{site}', 'User\SiteManageController@update')->name('サイト編集処理');
    Route::post('/user/site_manage/approve/{site}', 'User\SiteManageController@approve')->name('サイト登録申請');
    Route::delete('/user/site_manage/{site}', 'User\SiteManageController@delete')->name('サイト削除');
    Route::get('/user/site_manage/update_history/add/{site}', 'User\SiteManageController@addUpdateHistory')->name('サイト更新履歴登録');
    Route::post('/user/site_manage/update_history/add/{site}', 'User\SiteManageController@insertUpdateHistory')->name('サイト更新履歴登録処理');
    Route::get('/user/site_manage/update_history/edit/{siteUpdateHistory}', 'User\SiteManageController@editUpdateHistory')->name('サイト更新履歴編集');
    Route::patch('/user/site_manage/update_history/edit/{siteUpdateHistory}', 'User\SiteManageController@updateUpdateHistory')->name('サイト更新履歴編集処理');
    Route::delete('/user/site_manage/update_history/delete/{siteUpdateHistory}', 'User\SiteManageController@deleteUpdateHistory')->name('サイト更新履歴削除処理');

    Route::get('/user/site/access/{site}', 'User\SiteAccessController@index')->name('サイトアクセスログ');
    Route::get('/user/site/access/{site}/daily-footprint/{date}', 'User\SiteAccessController@dailyFootprint')->name('サイト日別足跡');
    Route::get('/user/site/access/{site}/footprint', 'User\SiteAccessController@footprint')->name('サイト足跡');

    // サイト
    Route::post('/site/good/{site}', 'Site\GoodController@good')->name('サイトいいね');
    Route::delete('/site/good/{site}', 'Site\GoodController@cancel')->name('サイトいいねキャンセル');
    
    // マイページ
    Route::get('/mypage', 'User\MyPageController@index')->name('マイページ');

    // ユーザー設定
    Route::get('/user/setting', 'User\SettingController@index')->name('ユーザー設定');

    // ユーザー設定：公開範囲
    Route::get('/user/setting/profile_open', 'User\Setting\ProfileController@openSetting')->name('プロフィール公開範囲設定');
    Route::patch('/user/setting/profile_open', 'User\Setting\ProfileController@saveOpenSetting')->name('プロフィール公開範囲設定保存');

    // ユーザー設定：プロフィール
    Route::get('/user/setting/profile', 'User\Setting\ProfileController@edit')->name('プロフィール編集');
    Route::patch('/user/setting/profile', 'User\Setting\ProfileController@save')->name('プロフィール編集実行');

    // ユーザー設定：年齢制限
    Route::get('/user/setting/rate', 'User\Setting\ProfileController@rate')->name('R-18表示設定');
    Route::patch('/user/setting/rate', 'User\Setting\ProfileController@saveRate')->name('R-18表示設定保存');

    // ユーザー設定：外部サイト認証設定
    Route::get('/user/setting/sns', 'User\SettingController@sns')->name('SNS認証設定');
    Route::patch('/user/setting/sns/{sa}/open', 'User\SettingController@updateSnsOpen')->name('SNS公開設定処理');
    Route::delete('/user/setting/sns/{sa}', 'User\SettingController@deleteSns')->name('SNS認証解除');

    // ユーザー設定：pixiv
    Route::post('/user/setting/sns/pixiv', 'User\SettingController@savePixiv')->name('pixiv保存');

    // ユーザー設定：メール認証
    Route::get('/user/setting/mail_auth', 'User\Setting\MailAuthController@register')->name('メール認証設定');
    Route::post('/user/setting/mail_auth', 'User\Setting\MailAuthController@sendAuthMail')->name('メール認証仮登録メール送信');
    Route::get('/user/setting/mail_auth/confirm', 'User\Setting\MailAuthController@register')->name('メール認証設定本登録');
    Route::delete('/user/setting/mail_auth', 'User\Setting\MailAuthController@delete')->name('メール認証設定削除');
    Route::get('/user/setting/change_mail', 'User\Setting\MailAuthController@changeMail')->name('メールアドレス変更');
    Route::post('/user/setting/change_mail', 'User\Setting\MailAuthController@sendChangeMail')->name('メールアドレス変更メール送信');
    Route::get('/user/setting/change_mail/confirm', 'User\Setting\MailAuthController@confirmMail')->name('メールアドレス変更確定');
    Route::get('/user/setting/change_password', 'User\Setting\MailAuthController@changePassword')->name('パスワード変更');
    Route::patch('/user/setting/change_password', 'User\Setting\MailAuthController@updatePassword')->name('パスワード変更処理');

    // ユーザー設定：アイコン
    Route::get('/user/setting/icon', 'User\Setting\IconController@changeIcon')->name('アイコン変更');
    Route::get('/user/setting/icon_round', 'User\Setting\IconController@changeIconRound')->name('アイコン丸み変更');
    Route::patch('/user/setting/icon_round', 'User\Setting\IconController@updateIconRound')->name('アイコン丸み変更処理');
    Route::get('/user/setting/icon_image', 'User\Setting\IconController@changeIconImage')->name('アイコン画像変更');
    Route::patch('/user/setting/icon_image', 'User\Setting\IconController@updateIconImage')->name('アイコン画像変更処理');
    Route::delete('/user/setting/icon', 'User\Setting\IconController@deleteIcon')->name('アイコン削除');

    // ユーザー設定足あと
    Route::get('/user/setting/footprint', 'User\Setting\ProfileController@footprint')->name('足あと設定');
    Route::patch('/user/setting/footprint', 'User\Setting\ProfileController@saveFootprint')->name('足あと設定保存');

    // お気に入りゲーム登録・削除
    Route::post('/user/favorite_soft', 'User\FavoriteSoftController@add')->name('お気に入りゲーム登録処理');
    Route::delete('/user/favorite_soft', 'User\FavoriteSoftController@remove')->name('お気に入りゲーム削除処理');
    Route::get('/user/favorite_soft/max/{soft}', 'User\FavoriteSoftController@max')->name('お気に入りゲームMAX');

    // お気に入りサイト登録・削除
    Route::post('/user/favorite_site/{site}', 'User\FavoriteSiteController@add')->name('お気に入りサイト登録処理');
    Route::delete('/user/favorite_site/{site}', 'User\FavoriteSiteController@remove')->name('お気に入りサイト削除処理');

    // フォロー登録・削除
    Route::post('/user/follow', 'User\FollowController@add')->name('フォロー登録');
    Route::delete('/user/follow', 'User\FollowController@remove')->name('フォロー解除');

    // 退会処理
    Route::get('/user/leave', 'Account\LeaveController@index')->name('退会');
    Route::delete('/user/leave', 'Account\LeaveController@leave')->name('退会処理');

    // メッセージ
    Route::get('/user/message/{message}', 'User\MessageController@show')->name('メッセージ表示');
    Route::get('/user/message/write/{resId}', 'User\MessageController@input')->name('メッセージ入力');
    Route::post('/user/message/write', 'User\MessageController@write')->name('メッセージ送信');
});

// トップ
Route::get('/', 'TopController@index')->name('トップ');

// 認証
Route::get('/auth/login', 'Account\LoginController@login')->name('ログイン');
Route::post('/auth/login', 'Account\LoginController@authenticate')->name('ログイン処理');
Route::get('/auth/logout', 'Account\LoginController@logout')->name('ログアウト');
Route::get('/auth/forget', 'Account\ForgotController@index')->name('パスワード再設定');
Route::post('/auth/send_forget', 'Account\ForgotController@sendPasswordResetMail')->name('パスワード再設定メール送信');
Route::get('/auth/password_reset', 'Account\ForgotController@reset')->name('パスワード再設定入力');
Route::post('/auth/password_reset', 'Account\ForgotController@update')->name('パスワード再設定処理');
Route::get('/auth/password_reset_complete', 'Account\ForgotController@complete')->name('パスワード再設定完了');

// お知らせ
Route::get('/notice', 'System\NoticeController@index')->name('お知らせ');
Route::get('/notice/{notice}', 'System\NoticeController@detail')->name('お知らせ内容');

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
Route::get('/review/new_arrivals', 'Review\ReviewController@newArrivals')->name('新着レビュー一覧');
Route::get('/review/about', 'Review\ReviewController@about')->name('レビューについて');

// 不正レビュー
Route::get('/review/fraud_report/report/{review}', 'Review\FraudReportController@input');
Route::post('/review/fraud_report/report/{review}', 'Review\FraudReportController@report');
Route::get('/review/fraud_report/list/{review}', 'Review\FraudReportController@list');

// サイト
Route::get('/site', 'Site\SiteController@index')->name('サイトトップ');
Route::get('/site/search', 'Site\SiteController@search')->name('サイト検索');
Route::get('/site/timeline', 'Site\SiteController@timeline')->name('サイトタイムライン');
Route::get('/site/new_arrival', 'Site\SiteController@newArrival')->name('新着サイト一覧');
Route::get('/site/update', 'Site\SiteController@updateArrival')->name('更新サイト一覧');
Route::get('/site/soft/{soft}', 'Site\SiteController@soft')->name('ソフト別サイト一覧');
Route::get('/site/user/{showId}', 'Site\SiteController@user')->name('ユーザーサイト一覧');
Route::get('/site/detail/{site}', 'Site\SiteController@detail')->name('サイト詳細');
Route::get('/site/go/{site}', 'Site\SiteController@go')->name('サイト遷移')->middleware(['goSite']);
Route::get('/site/update_history/{site}', 'Site\SiteController@updateHistory')->name('サイト更新履歴');

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

// SNS
Route::get('/social/twitter/callback', 'Social\TwitterController@callback')->name('Twitterコールバック');
Route::post('/social/twitter/{mode}', 'Social\TwitterController@redirect')->name('Twitter');
Route::get('/social/facebook/callback', 'Social\FacebookController@callback')->name('facebookコールバック');
Route::post('/social/facebook/{mode}', 'Social\FacebookController@redirect')->name('facebook');
Route::get('/social/github/callback', 'Social\GitHubController@callback')->name('GitHubコールバック');
Route::post('/social/github/{mode}', 'Social\GitHubController@redirect')->name('GitHub');
Route::get('/social/google/callback', 'Social\GoogleController@callback')->name('Googleコールバック');
Route::post('/social/google/{mode}', 'Social\GoogleController@redirect')->name('Google');

// その他
Route::get('/sitemap', 'TopController@sitemap')->name('サイトマップ');
Route::get('/new_information', 'TopController@newInformation')->name('新着情報');
Route::get('/about', 'TopController@about')->name('当サイトについて');
Route::get('/privacy', 'TopController@privacy')->name('プライバシーポリシー');
Route::get('/hgs', 'TopController@hgs')->name('HGSユーザーへ');

// フレンド
Route::get('/friend', 'Friend\FriendController@index')->name('フレンド');

// プロフィール
Route::get('/user/profile/{showId}', 'User\ProfileController@index')->name('プロフィール');
Route::get('/user/profile/{showId}/timeline/mypage', 'User\ProfileController@moreTimelineMyPage')->name('タイムライン追加取得');
Route::get('/user/profile/{showId}/{show}', 'User\ProfileController@index')->name('プロフィール2');

Route::get('/test', 'TopController@test');

// 新しいレイアウトのテスト用
Route::get('/n', 'NetworkLayout\TopController@index')->name('n.トップ');
Route::get('/network/game', 'NetworkLayout\GameController@index')->name('n.ゲーム');
Route::get('/network/game/detail/{game}', 'NetworkLayout\GameController@detail')->name('n.ゲーム詳細');

Route::get('/content/about', 'Content\TopController@about')->name('c.当サイトについて');
Route::get('/content/privacy', 'Content\TopController@privacy')->name('c.プライバシーポリシー');
Route::get('/content/sitemap', 'Content\TopController@sitemap')->name('c.サイトマップ');
Route::get('/content/hgs', 'Content\TopController@hgs')->name('c.HGSユーザーへ');

