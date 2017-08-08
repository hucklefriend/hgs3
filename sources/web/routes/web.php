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
Route::get('/auth/login', 'Auth\LoginController@login')->name('login');
Route::post('/auth/login', 'Auth\LoginController@authenticate');
Route::get('/auth/logout', 'Auth\LoginController@logout');

Route::get('/game/soft', 'Game\SoftController@index');
Route::post('/game/soft/comment/{game}', 'Game\SoftController@writeComment');
Route::get('/game/soft/{game}', 'Game\SoftController@show');

Route::get('/game/request', 'Game\RequestController@index')->middleware('auth');
Route::get('/game/request/input', 'Game\RequestController@input');
Route::post('/game/request', 'Game\RequestController@store')->middleware('auth');
Route::get('/game/request/edit/all', 'Game\RequestController@editListAll');
Route::get('/game/request/edit/{game}', 'Game\RequestController@editList');
Route::get('/game/request/show/edit/{gur}', 'Game\RequestController@showEdit');
Route::get('/game/request/input/edit/{game}', 'Game\RequestController@inputEdit');
Route::post('/game/request/input/edit/{game}', 'Game\RequestController@storeUpdate');
Route::get('/game/request/{gar}', 'Game\RequestController@show');

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

// お気に入りゲーム
Route::get('/game/favorite/{game}', 'Game\FavoriteGameController@index');
Route::get('/mypage/favorite_game', 'User\FavoriteGameController@myself')->middleware('auth');
Route::post('/user/favorite_game', 'User\FavoriteGameController@add')->middleware('auth');
Route::delete('/user/favorite_game', 'User\FavoriteGameController@remove')->middleware('auth');
Route::get('/user/favorite_game/{user}', 'User\FavoriteGameController@index');

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

// コミュニティ
Route::get('/community', 'Community\CommunityController@index');
Route::post('/community/u/{uc}/join', 'Community\UserCommunityController@join')->middleware('auth');
Route::post('/community/u/{uc}/secession', 'Community\UserCommunityController@secession')->middleware('auth');
Route::get('/community/u/{uc}/member', 'Community\UserCommunityController@members')->middleware('auth');
Route::get('/community/u/{uc}/topics', 'Community\UserCommunityController@topics')->middleware('auth');
Route::get('/community/u/{uc}/topic/{uct}', 'Community\UserCommunityController@topicDetail')->middleware('auth');
Route::get('/community/u/{uc}', 'Community\UserCommunityController@detail')->middleware('auth');