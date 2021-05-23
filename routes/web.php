<?php
use Hgs3\Http\Controllers;


// 管理者のみ
Route::group(['middleware' => ['auth', 'can:admin']], function () {
    // 管理メニュー
    Route::get('/admin', [Controllers\AdminController::class, 'index'])->name('管理メニュー');

    // お知らせ
    Route::get('/system/notice/add', [Controllers\System\NoticeController::class, 'System\NoticeController@add'])->name('お知らせ登録');
    Route::post('/system/notice/add', [Controllers\System\NoticeController::class, 'insert'])->name('お知らせ登録処理');
    Route::get('/system/notice/edit/{notice}', [Controllers\System\NoticeController::class, 'edit'])->name('お知らせ編集');
    Route::patch('/system/notice/edit/{notice}', [Controllers\System\NoticeController::class, 'update'])->name('お知らせ編集処理');
    Route::delete('/system/notice/{notice}', [Controllers\System\NoticeController::class, 'delete'])->name('お知らせ削除');
    Route::get('/system/notice/future', [Controllers\System\NoticeController::class, 'future'])->name('未来のお知らせ');
    Route::get('/system/notice/past', [Controllers\System\NoticeController::class, 'past'])->name('過去のお知らせ');

    // 不正レビュー
    //Route::get('/admin/injustice_review', [InjusticeReviewController, 'Admin\InjusticeReviewController@index']);

    // タイムライン管理
    Route::get('/timeline', [Controllers\TimelineController::class, 'index'])->name('タイムライン管理');
    Route::get('/timeline/add', [Controllers\TimelineController::class,'input'])->name('タイムライン登録');
    Route::post('/timeline/add', [Controllers\TimelineController::class,'add'])->name('タイムライン登録処理');
    Route::delete('/timeline/', [Controllers\TimelineController::class,'remove'])->name('タイムライン削除処理');


    // 管理者によるサイト管理
    Route::get('/admin/site/approval', [Controllers\Site\ApprovalController::class, 'index'])->name('承認待ちサイト一覧');
    Route::get('/admin/site/approval/judge/{site}', [Controllers\Site\ApprovalController::class, 'judge'])->name('サイト判定');
    Route::patch('/admin/site/approval/judge/{site}/approve', [Controllers\Site\ApprovalController::class, 'approve'])->name('サイト承認');
    Route::patch('/admin/site/approval/judge/{site}/reject', [Controllers\Site\ApprovalController::class, 'reject'])->name('サイト拒否');

    // 管理人によるレビューURL管理
    Route::get('/admin/review/url', [Controllers\Site\ApprovalController::class, 'index'])->name('レビューURL判定');
    Route::patch('/admin/review/url/ok', [Controllers\Site\ApprovalController::class, 'ok'])->name('レビューURL OK');
    Route::patch('/admin/review/url/ng', [Controllers\Site\ApprovalController::class, 'ng'])->name('レビューURL NG');

    Route::get('/admin/hgs2site', [Controllers\AdminController::class, 'hgs2SiteChecker']);

    // 管理人メッセージ
    //Route::get('/admin/message/write/{user}/{resId}', 'User\MessageController@adminInput')->name('管理人メッセージ入力');
    //Route::post('/admin/message/write/{user}', 'User\MessageController@adminWrite')->name('管理人メッセージ送信');

    // ユーザー管理
    //Route::get('/admin/user')->name('ユーザー管理');
});


// ユーザーのみ
Route::group(['middleware' => ['auth']], function () {
    // レビュー
    Route::post('/user/review/save', [Controllers\User\ReviewController::class, 'save'])->name('レビュー保存');
    Route::get('/user/review/confirm/{soft}', [Controllers\User\ReviewController::class, 'confirm'])->name('レビュー投稿確認');
    Route::get('/user/review/write/{soft}', [Controllers\User\ReviewController::class, 'input'])->name('レビュー入力');
    Route::get('/user/review/{soft}/playing', [Controllers\User\ReviewController::class, 'inputPlaying'])->name('レビュープレイ状況入力');
    Route::post('/user/review/{soft}/playing', [Controllers\User\ReviewController::class, 'savePlaying'])->name('レビュープレイ状況保存');
    Route::get('/user/review/{soft}/fear', [Controllers\User\ReviewController::class, 'inputFear'])->name('レビュー怖さ入力');
    Route::post('/user/review/{soft}/fear', [Controllers\User\ReviewController::class, 'saveFear'])->name('レビュー怖さ保存');
    Route::get('/user/review/{soft}/good', [Controllers\User\ReviewController::class, 'inputGood'])->name('レビュー良い点入力');
    Route::post('/user/review/{soft}/good', [Controllers\User\ReviewController::class, 'saveGood'])->name('レビュー良い点保存');
    Route::get('/user/review/{soft}/bad', [Controllers\User\ReviewController::class, 'inputBad'])->name('レビュー悪い点入力');
    Route::post('/user/review/{soft}/bad', [Controllers\User\ReviewController::class, 'saveBad'])->name('レビュー悪い点保存');
    Route::get('/user/review/{soft}/general', [Controllers\User\ReviewController::class, 'inputGeneral'])->name('レビュー総評入力');
    Route::post('/user/review/{soft}/general', [Controllers\User\ReviewController::class, 'saveGeneral'])->name('レビュー総評保存');
    Route::patch('/user/review/{soft}/spoiler', [Controllers\User\ReviewController::class, 'saveSpoiler'])->name('レビューネタバレありだった');
    Route::patch('/user/review/{soft}/not_spoiler', [Controllers\User\ReviewController::class, 'saveNotSpoiler'])->name('レビューネタバレなしだった');
    Route::post('/user/review/write/{soft}', [Controllers\User\ReviewController::class, 'open'])->name('レビュー公開');
    Route::delete('/user/review/{review}', [Controllers\User\ReviewController::class, 'delete'])->name('レビュー削除');
    Route::put('/user/review/fmfm/{review}', [Controllers\Review\ImpressionController::class, 'fmfm'])->name('ふむふむ');
    Route::put('/user/review/n/{review}', [Controllers\Review\ImpressionController::class, 'n'])->name('んー…');
    Route::delete('/user/review/impression/{review}', [Controllers\Review\ImpressionController::class, 'delete'])->name('レビュー印象取り消し');

    // サイト管理
    Route::get('/user/site_manage', [Controllers\User\SiteManageController::class, 'index'])->name('サイト管理');
    Route::get('/user/site_manage/add', [Controllers\User\SiteManageController::class, 'add'])->name('サイト登録');
    Route::post('/user/site_manage/add', [Controllers\User\SiteManageController::class, 'insert'])->name('サイト登録処理');
    Route::get('/user/site_manage/banner/{site}/{isFirst}', [Controllers\User\SiteManageController::class, 'banner'])->name('サイトバナー設定');
    Route::post('/user/site_manage/banner/{site}', [Controllers\User\SiteManageController::class, 'saveBanner'])->name('サイトバナー設定処理');
    Route::get('/user/site_manage/r18banner/{site}/{isFirst}', [Controllers\User\SiteManageController::class, 'bannerR18'])->name('R-18サイトバナー設定');
    Route::post('/user/site_manage/r18banner/{site}', [Controllers\User\SiteManageController::class, 'saveBannerR18'])->name('R-18サイトバナー設定処理');
    Route::get('/user/site_manage/edit/{site}', [Controllers\User\SiteManageController::class, 'edit'])->name('サイト編集');
    Route::patch('/user/site_manage/edit/{site}', [Controllers\User\SiteManageController::class, 'update'])->name('サイト編集処理');
    Route::post('/user/site_manage/approve/{site}', [Controllers\User\SiteManageController::class, 'approve'])->name('サイト登録申請');
    Route::delete('/user/site_manage/{site}', [Controllers\User\SiteManageController::class, 'delete'])->name('サイト削除');
    Route::get('/user/site_manage/update_history/add/{site}', [Controllers\User\SiteManageController::class, 'addUpdateHistory'])->name('サイト更新履歴登録');
    Route::post('/user/site_manage/update_history/add/{site}', [Controllers\User\SiteManageController::class, 'insertUpdateHistory'])->name('サイト更新履歴登録処理');
    Route::get('/user/site_manage/update_history/edit/{siteUpdateHistory}', [Controllers\User\SiteManageController::class, 'editUpdateHistory'])->name('サイト更新履歴編集');
    Route::patch('/user/site_manage/update_history/edit/{siteUpdateHistory}', [Controllers\User\SiteManageController::class, 'updateUpdateHistory'])->name('サイト更新履歴編集処理');
    Route::delete('/user/site_manage/update_history/delete/{siteUpdateHistory}', [Controllers\User\SiteManageController::class, 'deleteUpdateHistory'])->name('サイト更新履歴削除処理');

    Route::get('/user/site/access/{site}', [Controllers\User\SiteAccessController::class, 'index'])->name('サイトアクセスログ');
    Route::get('/user/site/access/{site}/daily-footprint/{date}', [Controllers\User\SiteAccessController::class, 'dailyFootprint'])->name('サイト日別足跡');
    Route::get('/user/site/access/{site}/footprint', [Controllers\User\SiteAccessController::class, 'footprint'])->name('サイト足跡');

    // サイト
    Route::post('/site/good/{site}', [Controllers\Site\GoodController::class, 'good'])->name('サイトいいね');
    Route::delete('/site/good/{site}', [Controllers\Site\GoodController::class, 'cancel'])->name('サイトいいねキャンセル');
    
    // マイページ
    Route::get('/mypage', [Controllers\User\MyPageController::class, 'index'])->name('マイページ');

    // ユーザー設定
    Route::get('/user/setting', [Controllers\User\SettingController::class, 'index'])->name('ユーザー設定');

    // ユーザー設定：公開範囲
    Route::get('/user/setting/profile_open', [Controllers\User\Setting\ProfileController::class, 'openSetting'])->name('プロフィール公開範囲設定');
    Route::patch('/user/setting/profile_open', [Controllers\User\Setting\ProfileController::class, 'saveOpenSetting'])->name('プロフィール公開範囲設定保存');

    // ユーザー設定：プロフィール
    Route::get('/user/setting/profile', [Controllers\User\Setting\ProfileController::class, 'edit'])->name('プロフィール編集');
    Route::patch('/user/setting/profile', [Controllers\User\Setting\ProfileController::class, 'save'])->name('プロフィール編集実行');

    // ユーザー設定：年齢制限
    Route::get('/user/setting/rate', [Controllers\User\Setting\ProfileController::class, 'rate'])->name('R-18表示設定');
    Route::patch('/user/setting/rate', [Controllers\User\Setting\ProfileController::class, 'saveRate'])->name('R-18表示設定保存');

    // ユーザー設定：外部サイト認証設定
    Route::get('/user/setting/sns', [Controllers\User\SettingController::class, 'sns'])->name('SNS認証設定');
    Route::patch('/user/setting/sns/{sa}/open', [Controllers\User\SettingController::class, 'updateSnsOpen'])->name('SNS公開設定処理');
    Route::delete('/user/setting/sns/{sa}', [Controllers\User\SettingController::class, 'deleteSns'])->name('SNS認証解除');

    // ユーザー設定：pixiv
    Route::post('/user/setting/sns/pixiv', [Controllers\User\SettingController::class, 'savePixiv'])->name('pixiv保存');

    // ユーザー設定：メール認証
    Route::get('/user/setting/mail_auth', [Controllers\User\Setting\MailAuthController::class, 'register'])->name('メール認証設定');
    Route::post('/user/setting/mail_auth', [Controllers\User\Setting\MailAuthController::class, 'sendAuthMail'])->name('メール認証仮登録メール送信');
    Route::get('/user/setting/mail_auth/confirm', [Controllers\User\Setting\MailAuthController::class, 'register'])->name('メール認証設定本登録');
    Route::delete('/user/setting/mail_auth', [Controllers\User\Setting\MailAuthController::class, 'delete'])->name('メール認証設定削除');
    Route::get('/user/setting/change_mail', [Controllers\User\Setting\MailAuthController::class, 'changeMail'])->name('メールアドレス変更');
    Route::post('/user/setting/change_mail', [Controllers\User\Setting\MailAuthController::class, 'sendChangeMail'])->name('メールアドレス変更メール送信');
    Route::get('/user/setting/change_mail/confirm', [Controllers\User\Setting\MailAuthController::class, 'confirmMail'])->name('メールアドレス変更確定');
    Route::get('/user/setting/change_password', [Controllers\User\Setting\MailAuthController::class, 'changePassword'])->name('パスワード変更');
    Route::patch('/user/setting/change_password', [Controllers\User\Setting\MailAuthController::class, 'updatePassword'])->name('パスワード変更処理');

    // ユーザー設定：アイコン
    Route::get('/user/setting/icon', [Controllers\User\Setting\IconController::class, 'changeIcon'])->name('アイコン変更');
    Route::get('/user/setting/icon_round', [Controllers\User\Setting\IconController::class, 'changeIconRound'])->name('アイコン丸み変更');
    Route::patch('/user/setting/icon_round', [Controllers\User\Setting\IconController::class, 'updateIconRound'])->name('アイコン丸み変更処理');
    Route::get('/user/setting/icon_image', [Controllers\User\Setting\IconController::class, 'changeIconImage'])->name('アイコン画像変更');
    Route::patch('/user/setting/icon_image', [Controllers\User\Setting\IconController::class, 'updateIconImage'])->name('アイコン画像変更処理');
    Route::delete('/user/setting/icon', [Controllers\User\Setting\IconController::class, 'deleteIcon'])->name('アイコン削除');

    // ユーザー設定足あと
    Route::get('/user/setting/footprint', [Controllers\User\Setting\ProfileController::class, 'User\Setting\ProfileController@footprint'])->name('足あと設定');
    Route::patch('/user/setting/footprint', [Controllers\User\Setting\ProfileController::class, 'User\Setting\ProfileController@saveFootprint'])->name('足あと設定保存');

    // お気に入りゲーム登録・削除
    Route::post('/user/favorite_soft', [Controllers\User\FavoriteSoftController::class, 'add'])->name('お気に入りゲーム登録処理');
    Route::delete('/user/favorite_soft', [Controllers\User\FavoriteSoftController::class, 'remove'])->name('お気に入りゲーム削除処理');
    Route::get('/user/favorite_soft/max/{soft}', [Controllers\User\FavoriteSoftController::class, 'max'])->name('お気に入りゲームMAX');

    // お気に入りサイト登録・削除
    Route::post('/user/favorite_site/{site}', [Controllers\User\FavoriteSiteController::class, 'add'])->name('お気に入りサイト登録処理');
    Route::delete('/user/favorite_site/{site}', [Controllers\User\FavoriteSiteController::class, 'remove'])->name('お気に入りサイト削除処理');

    // フォロー登録・削除
    Route::post('/user/follow', [Controllers\User\FollowController::class, 'add'])->name('フォロー登録');
    Route::delete('/user/follow', [Controllers\User\FollowController::class, 'remove'])->name('フォロー解除');

    // 退会処理
    Route::get('/user/leave', [Controllers\Account\LeaveController::class, 'index'])->name('退会');
    Route::delete('/user/leave', [Controllers\Account\LeaveController::class, 'leave'])->name('退会処理');

    // メッセージ
    /*
    Route::get('/user/message/{message}', [Controllers\User\MessageController::class, 'show'])->name('メッセージ表示');
    Route::get('/user/message/write/{resId}', [Controllers\User\MessageController::class, 'input'])->name('メッセージ入力');
    Route::post('/user/message/write', [Controllers\User\MessageController::class, 'write'])->name('メッセージ送信');
    */
});

// トップ
Route::get('/', [Controllers\TopController::class, 'index'])->name('トップ');

// 認証
Route::get('/auth/login', [Controllers\Account\LoginController::class, 'login'])->name('ログイン');
Route::post('/auth/login', [Controllers\Account\LoginController::class, 'authenticate'])->name('ログイン処理');
Route::get('/auth/logout', [Controllers\Account\LoginController::class, 'logout'])->name('ログアウト');
Route::get('/auth/forget', [Controllers\Account\ForgotController::class, 'index'])->name('パスワード再設定');
Route::post('/auth/send_forget', [Controllers\Account\ForgotController::class, 'sendPasswordResetMail'])->name('パスワード再設定メール送信');
Route::get('/auth/password_reset', [Controllers\Account\ForgotController::class, 'reset'])->name('パスワード再設定入力');
Route::post('/auth/password_reset', [Controllers\Account\ForgotController::class, 'update'])->name('パスワード再設定処理');
Route::get('/auth/password_reset_complete', [Controllers\Account\ForgotController::class, 'complete'])->name('パスワード再設定完了');

// お知らせ
Route::get('/notice', [Controllers\System\NoticeController::class, 'System\NoticeController@index'])->name('お知らせ');
Route::get('/notice/{notice}', [Controllers\System\NoticeController::class, 'System\NoticeController@detail'])->name('お知らせ内容');

// アカウント作成
Route::get('/account/signup', [Controllers\Account\SignUpController::class, 'index'])->name('ユーザー登録');
Route::post('/account/signup/pr', [Controllers\Account\SignUpController::class, 'sendPRMail'])->name('仮登録メール送信');
Route::get('/account/register/{token}', [Controllers\Account\SignUpController::class, 'register'])->name('本登録');
Route::post('/account/register', [Controllers\Account\SignUpController::class, 'registration'])->name('本登録処理');

// ゲーム
Route::get('/game/soft', [Controllers\Game\SoftController::class, 'index'])->name('ゲーム一覧');
Route::get('/game/soft/package/{packageId}', [Controllers\Game\SoftController::class, 'detailByPackage'])->name('パッケージからゲーム詳細');
Route::get('/game/soft/{soft?}', [Controllers\Game\SoftController::class, 'detail'])->name('ゲーム詳細');

// レビュー
Route::get('/review', [Controllers\Review\ReviewController::class, 'index'])->name('レビュートップ');
Route::get('/review/soft/{soft}', [Controllers\Review\ReviewController::class, 'soft'])->name('ソフト別レビュー一覧');
Route::get('/review/detail/{review}', [Controllers\Review\ReviewController::class, 'detail'])->name('レビュー');
Route::get('/review/new_arrivals', [Controllers\Review\ReviewController::class, 'newArrivals'])->name('新着レビュー一覧');
Route::get('/review/about', [Controllers\Review\ReviewController::class, 'about'])->name('レビューについて');

// 不正レビュー
Route::get('/review/fraud_report/report/{review}', [Controllers\Review\FraudReportController::class, 'input']);
Route::post('/review/fraud_report/report/{review}', [Controllers\Review\FraudReportController::class, 'report']);
Route::get('/review/fraud_report/list/{review}', [Controllers\Review\FraudReportController::class, 'list']);

// サイト
Route::get('/site', [Controllers\Site\SiteController::class, 'index'])->name('サイトトップ');
Route::get('/site/search', [Controllers\Site\SiteController::class, 'search'])->name('サイト検索');
Route::get('/site/timeline', [Controllers\Site\SiteController::class, 'timeline'])->name('サイトタイムライン');
Route::get('/site/new_arrival', [Controllers\Site\SiteController::class, 'newArrival'])->name('新着サイト一覧');
Route::get('/site/update', [Controllers\Site\SiteController::class, 'updateArrival'])->name('更新サイト一覧');
Route::get('/site/soft/{soft}', [Controllers\Site\SiteController::class, 'soft'])->name('ソフト別サイト一覧');
Route::get('/site/user/{showId}', [Controllers\Site\SiteController::class, 'user'])->name('ユーザーサイト一覧');
Route::get('/site/detail/{site}', [Controllers\Site\SiteController::class, 'detail'])->name('サイト詳細');
Route::get('/site/go/{site}', [Controllers\Site\SiteController::class, 'go'])->name('サイト遷移')->middleware(['goSite']);
Route::get('/site/update_history/{site}', [Controllers\Site\SiteController::class, 'updateHistory'])->name('サイト更新履歴');

// ゲーム会社
Route::get('/game/company', [Controllers\Game\CompanyController::class, 'index'])->name('ゲーム会社一覧');
Route::get('/game/company/{company}', [Controllers\Game\CompanyController::class, 'detail'])->name('ゲーム会社詳細');

// プラットフォーム
Route::get('/game/platform', [Controllers\Game\PlatformController::class, 'index'])->name('プラットフォーム一覧');
Route::get('/game/platform/{platform}', [Controllers\Game\PlatformController::class, 'detail'])->name('プラットフォーム詳細');

// シリーズ
Route::get('/game/series', [Controllers\Game\SeriesController::class, 'index'])->name('シリーズ一覧');
Route::get('/game/series/{series}', [Controllers\Game\SeriesController::class, 'detail'])->name('シリーズ詳細');

// お気に入りゲーム
Route::get('/game/favorite/{soft}', [Controllers\Game\FavoriteSoftController::class, 'index'])->name('お気に入りゲーム登録ユーザー一覧');

// SNS
Route::get('/social/twitter/callback', [Controllers\Social\TwitterController::class, 'callback'])->name('Twitterコールバック');
Route::post('/social/twitter/{mode}', [Controllers\Social\TwitterController::class, 'redirect'])->name('Twitter');
Route::get('/social/facebook/callback', [Controllers\Social\FacebookController::class, 'callback'])->name('facebookコールバック');
Route::post('/social/facebook/{mode}', [Controllers\Social\FacebookController::class, 'redirect'])->name('facebook');
Route::get('/social/github/callback', [Controllers\Social\GitHubController::class, 'callback'])->name('GitHubコールバック');
Route::post('/social/github/{mode}', [Controllers\Social\GitHubController::class, 'redirect'])->name('GitHub');
Route::get('/social/google/callback', [Controllers\Social\GoogleController::class, 'callback'])->name('Googleコールバック');
Route::post('/social/google/{mode}', [Controllers\Social\GoogleController::class, 'redirect'])->name('Google');

// その他
Route::get('/sitemap', [Controllers\TopController::class, 'sitemap'])->name('サイトマップ');
Route::get('/new_information', [Controllers\TopController::class, 'newInformation'])->name('新着情報');
Route::get('/about', [Controllers\TopController::class, 'about'])->name('当サイトについて');
Route::get('/privacy', [Controllers\TopController::class, 'privacy'])->name('プライバシーポリシー');
Route::get('/hgs', [Controllers\TopController::class, 'hgs'])->name('HGSユーザーへ');

// フレンド
Route::get('/friend', [Controllers\Friend\FriendController::class, 'index'])->name('フレンド');

// プロフィール
Route::get('/user/profile/{showId}', [Controllers\User\ProfileController::class, 'index'])->name('プロフィール');
Route::get('/user/profile/{showId}/timeline/mypage', [Controllers\User\ProfileController::class, 'moreTimelineMyPage'])->name('タイムライン追加取得');
Route::get('/user/profile/{showId}/{show}', [Controllers\User\ProfileController::class, 'index'])->name('プロフィール2');

Route::get('/test', [Controllers\TopController::class, 'test']);

// 新しいレイアウトのテスト用
/*
Route::get('/n', 'Network\TopController@index')->name('n.トップ');
Route::get('/network/game', 'Network\GameController@index')->name('n.ゲーム');
Route::get('/network/game/company', 'Network\Game\CompanyController@index')->name('n.ゲーム会社');
Route::get('/network/game/company/{company}', 'Network\Game\CompanyController@detail')->name('n.ゲーム会社詳細');
Route::get('/network/game/detail/{game}', 'Network\GameController@detail')->name('n.ゲーム詳細');

Route::get('/content/about', 'Content\TopController@about')->name('c.当サイトについて');
Route::get('/content/privacy', 'Content\TopController@privacy')->name('c.プライバシーポリシー');
Route::get('/content/sitemap', 'Content\TopController@sitemap')->name('c.サイトマップ');
Route::get('/content/hgs', 'Content\TopController@hgs')->name('c.HGSユーザーへ');
*/
