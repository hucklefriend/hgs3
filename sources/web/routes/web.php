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

Route::get('/game/soft', 'Game\SoftController@index');
Route::post('/game/soft/comment/{game}', 'Game\SoftController@writeComment');
Route::get('/game/soft/{game}', 'Game\SoftController@show');

// ゲーム追加リクエスト
Route::get('/game/request', 'Game\RequestController@index')->middleware(['auth', 'web']);
Route::get('/game/request/input', 'Game\RequestController@input')->middleware(['auth', 'web']);
Route::post('/game/request', 'Game\RequestController@store')->middleware('auth');
Route::post('/game/request/{gr}/comment', 'Game\RequestController@writeComment')->middleware(['auth']);
Route::delete('/game/request/{gr}/comment/{grc}', 'Game\RequestController@deleteComment')->middleware(['auth']);
Route::post('/game/request/{gr}/change_status', 'Game\RequestController@changeStatus')->middleware(['auth']);
Route::get('/game/request/{gr}', 'Game\RequestController@show')->middleware(['web']);

// レビュー
Route::get('/game/review', 'Game\ReviewController@index');
Route::get('/game/review/input/{game}', 'Game\ReviewController@input')->middleware('auth');
Route::post('/game/review/confirm/{game}', 'Game\ReviewController@confirm')->middleware('auth');
Route::post('/game/review/save/{game}', 'Game\ReviewController@save')->middleware('auth');
Route::get('/game/review/soft/{game}', 'Game\ReviewController@soft');
Route::post('/game/review/good/{review}', 'Game\ReviewController@good')->middleware('auth');
Route::delete('/game/review/good/{review}', 'Game\ReviewController@cancelGood')->middleware('auth');
Route::get('/game/review/detail/{review}', 'Game\ReviewController@show');
Route::get('/game/review/good_history/{review}', 'Game\ReviewController@goodHistory');

// 不正レビュー
Route::get('/game/injustice_review/input/{review}', 'Game\InjusticeReviewController@input');
Route::post('/game/injustice_review/input/{review}', 'Game\InjusticeReviewController@report');
Route::get('/game/injustice_review/detail/{ir}', 'Game\InjusticeReviewController@detail');
Route::post('/game/injustice_review/comment/{ir}', 'Game\InjusticeReviewController@comment');
Route::get('/game/injustice_review/{review}', 'Game\InjusticeReviewController@list');

// サイト
Route::get('/site', 'Site\SearchController@index');
Route::get('/site/search', 'Site\SearchController@search');
Route::get('/site/game/{game}', 'Site\SearchController@game');
Route::get('/site/user/{user}', 'Site\SearchController@user');
Route::get('/site/detail/{site}', 'Site\SearchController@show');



Route::get('/game/company', 'Game\CompanyController@index');
Route::get('/game/company/{gameCompany}', 'Game\CompanyController@show');


// マイページ
Route::get('/mypage', 'User\MyPageController@index')->middleware('auth');
Route::get('/user/profile/edit', 'User\ProfileController@edit')->middleware('auth');
Route::post('/user/profile/edit', 'User\ProfileController@update')->middleware('auth');
Route::get('/user/profile/{user}', 'User\ProfileController@index')->middleware('auth');
Route::get('/user/profile', 'User\ProfileController@myself')->middleware('auth');
Route::get('/user/communities/{user}', 'User\ProfileController@community')->middleware('auth');

// お気に入りゲーム
Route::get('/game/favorite/{game}', 'Game\FavoriteGameController@index');
Route::get('/mypage/favorite_game', 'User\FavoriteGameController@myself')->middleware('auth');
Route::post('/user/favorite_game', 'User\FavoriteGameController@add')->middleware('auth');
Route::delete('/user/favorite_game', 'User\FavoriteGameController@remove')->middleware('auth');
Route::get('/user/favorite_game/{user}', 'User\FavoriteGameController@index');

// 遊んだゲーム
Route::get('game/played_user/{game}', 'Game\PlayedUserController@index');
Route::get('user/played_game/{user}', 'User\PlayedGameController@index');
Route::post('user/played_game/{game}', 'User\PlayedGameController@add')->middleware('auth');
Route::put('user/played_game/{upg}', 'User\PlayedGameController@edit')->middleware('auth');
Route::delete('user/played_game/{upg}', 'User\PlayedGameController@remove')->middleware('auth');


// お気に入りサイト
Route::get('/site/favorite/{site}', 'Site\FavoriteSiteController@index');
Route::get('/mypage/favorite_site', 'User\FavoriteSiteController@myself')->middleware('auth');
Route::post('/user/favorite_site', 'User\FavoriteSiteController@add')->middleware('auth');
Route::delete('/user/favorite_site', 'User\FavoriteSiteController@remove')->middleware('auth');
Route::get('/user/favorite_site/{user}', 'User\FavoriteSiteController@index');

// 自分のサイト
Route::get('/user/site/myself', 'User\SiteController@myself')->middleware('auth');
Route::get('/user/site/add', 'User\SiteController@add')->middleware('auth');
Route::post('/user/site/add', 'User\SiteController@store')->middleware('auth');
Route::get('/user/site/edit/{site}', 'User\SiteController@edit')->middleware('auth');
Route::get('/user/site/edit/{site}', 'User\SiteController@edit')->middleware('auth');
Route::get('/user/site/{site}', 'User\SiteController@detail')->middleware('auth');

// フォロー
Route::get('/user/follow/{user}', 'User\ProfileController@follow')->middleware('auth');
Route::get('/user/follower/{user}', 'User\ProfileController@follower')->middleware('auth');
Route::post('/user/follow', 'User\FollowController@add')->middleware('auth');
Route::delete('/user/follow', 'User\FollowController@remove')->middleware('auth');

// コミュニティ
Route::get('/community', 'Community\CommunityController@index');

Route::post('/community/u/{uc}/join', 'Community\UserCommunityController@join')->middleware('auth');
Route::post('/community/u/{uc}/secession', 'Community\UserCommunityController@secession')->middleware('auth');
Route::get('/community/u/{uc}/member', 'Community\UserCommunityController@members')->middleware('auth');
Route::get('/community/u/{uc}/topics', 'Community\UserCommunityController@topics')->middleware('auth');
Route::post('/community/u/{uc}/topics', 'Community\UserCommunityController@write')->middleware('auth');
Route::get('/community/u/{uc}/topic/{uct}', 'Community\UserCommunityController@topicDetail')->middleware('auth');
Route::post('/community/u/{uc}/topic/{uct}', 'Community\UserCommunityController@writeResponse')->middleware('auth');
Route::delete('/community/u/{uc}/topic/{uct}', 'Community\UserCommunityController@erase')->middleware('auth');
Route::delete('/community/u/{uc}/topic_response/{uctr}', 'Community\UserCommunityController@eraseResponse')->middleware('auth');
Route::get('/community/u/{uc}', 'Community\UserCommunityController@detail')->middleware('auth');

Route::post('/community/g/{game}/join', 'Community\GameCommunityController@join')->middleware('auth');
Route::post('/community/g/{game}/secession', 'Community\GameCommunityController@secession')->middleware('auth');
Route::get('/community/g/{game}/member', 'Community\GameCommunityController@members')->middleware('auth');
Route::get('/community/g/{game}/topics', 'Community\GameCommunityController@topics')->middleware('auth');
Route::post('/community/g/{game}/topics', 'Community\GameCommunityController@write')->middleware('auth');
Route::get('/community/g/{game}/topic/{gct}', 'Community\GameCommunityController@topicDetail')->middleware('auth');
Route::post('/community/g/{game}/topic/{gct}', 'Community\GameCommunityController@writeResponse')->middleware('auth');
Route::delete('/community/g/{game}/topic/{gct}', 'Community\GameCommunityController@erase')->middleware('auth');
Route::delete('/community/g/{game}/topic_response/{gctr}', 'Community\GameCommunityController@eraseResponse')->middleware('auth');
Route::get('/community/g/{game}', 'Community\GameCommunityController@detail')->middleware('auth');
Route::get('/community/g', 'Community\GameCommunityController@index');
