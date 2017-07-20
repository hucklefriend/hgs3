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

Route::get('/site', 'Site\SearchController@index');
Route::get('/site/show/{site}', 'Site\SearchController@show');


Route::get('/site/manage', 'Site\ManageController@index')->middleware('auth');
Route::get('/site/manage/add', 'Site\ManageController@add')->middleware('auth');
Route::get('/site/manage/edit/{site}', 'Site\ManageController@edit')->middleware('auth');


Route::get('/game/company', 'Game\CompanyController@index');
Route::get('/game/company/{gameCompany}', 'Game\CompanyController@show');


// マイページ
Route::get('/mypage', 'User\MyPageController@index')->middleware('auth');
Route::get('/user/profile/edit', 'User\ProfileController@edit')->middleware('auth');
Route::post('/user/profile/edit', 'User\ProfileController@update')->middleware('auth');
Route::get('/user/profile/{user}', 'User\ProfileController@index')->middleware('auth');
Route::get('/user/profile', 'User\ProfileController@myself')->middleware('auth');
